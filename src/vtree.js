/* global d3 */

import Node from './node/node.js';
import StringNode from './node/string.js';
import TableNode from './node/table.js';
import ArrayNode from './node/array.js';

import TreeLayout from './layout/tree.js';
import ArrayLayout from './layout/array.js';

import ObjectReader from './reader/object.js';

import { visitAfter } from './util.js';


const WIDTH = 960;
const HEIGHT = 800;
const MARGIN = 20;

const DEFAULT_TREE_LAYOUT_HEIGHT = 50;
const DEBUG_TREE_LAYOUT_HEIGHT = 100;

const style = `
.vtree-node text { font: 14px sans-serif; }
.vtree-link { fill: none; stroke: #888; stroke-width: 2px; }
.vtree-table { stroke-width: 2px; stroke: steelblue; }
path.vtree-table { fill: white; }
g.vtree-node rect { fill: white; stroke: black; stroke-width: 1px; }
g.vtree-node rect.number-text { fill: #d8f0ed; }
g.vtree-node rect.string-text { fill: #e7f0db; }
g.vtree-node rect.boolean-text { fill: #e1d8f0; }
g.vtree-node rect.null-text { fill: #888; }
`;


class VTree {
  constructor(container) {
    this.root = new ArrayNode([], new ArrayLayout({ hideLinks: true }));
    this.defaultLayout = new TreeLayout({height: DEFAULT_TREE_LAYOUT_HEIGHT});
    this.container = container;
    this._width = WIDTH;
    this._height = HEIGHT;
    this._debug = false;

    this.d3 = {};

    this.d3.container = d3.select(this.container);

    this.d3.zoomListener = d3.behavior.zoom()
      .scaleExtent([0.1, 10])
      .on('zoom', () => {
        const e = d3.event;

        if (this.d3.g) {
          this.d3.g.attr('transform', `translate(${e.translate})scale(${e.scale})`);
        }
      });

    this.d3.svg = this.d3.container.append('svg')
      .attr('class', 'vtree')
      .attr('width', this._width)
      .attr('height', this._height)
      .call(this.d3.zoomListener);
  }

  width(width) {
    if (arguments.length === 0) {
      return this._width;
    }

    this._width = width;

    this.d3.container.select('svg')
      .attr('width', width);

    return this;
  }

  height(height) {
    if (arguments.length === 0) {
      return this._height;
    }

    this._height = height;

    this.d3.container.select('svg')
      .attr('height', height);

    return this;
  }

  debug(debug) {
    if (arguments.length === 0) {
      return this._debug;
    }

    if (debug) {
      this.defaultLayout.height = DEBUG_TREE_LAYOUT_HEIGHT;
    } else {
      this.defaultLayout.height = DEFAULT_TREE_LAYOUT_HEIGHT;
    }

    this._debug = debug;

    return this;
  }

  data(data) {
    if (Array.isArray(data)) {
      this.root.children = data;
    } else {
      this.root.children = [data];
    }

    return this;
  }

  createSvgString() {
    var svg = this.d3.svg.node();
    var serializer = new XMLSerializer();
    var source = serializer.serializeToString(svg);

    if (!source.match(/^<svg[^>]+xmlns="http:\/\/www\.w3\.org\/2000\/svg"/)) {
      source = source.replace(/^<svg/, '<svg xmlns="http://www.w3.org/2000/svg"');
    }

    if (!source.match(/^<svg[^>]+"http:\/\/www\.w3\.org\/1999\/xlink"/)) {
      source = source.replace(/^<svg/, '<svg xmlns:xlink="http://www.w3.org/1999/xlink"');
    }

    source = '<?xml version="1.0" standalone="no"?>\r\n' + source;

    return source;
  }

  createTreeGroups(parentG, depth) {
    var hasChildren = false;

    const g = parentG
      .selectAll('g.vtree-node')
      .data(function (d) {
        if (d.children.length !== 0) {
          hasChildren = true;
        }

        return d.children;
      })
      .enter()
      .append('g')
      .attr('class', 'vtree-node')
      .each(function (d) {
        d.g = d3.select(this);
      });

    if (hasChildren) {
      this.createTreeGroups(g, depth + 1);
    }
  }

  update() {
    const root = {
      id: 1,
      children: [this.root]
    };

    this.d3.svg.selectAll('*').remove();

    this.d3.svg.append('style').text(style);

    this._debugDrawGrid();

    this.d3.g = this.d3.svg.selectAll('g.vtree-root')
      .data([root])
      .enter()
      .append('g')
      .attr('class', 'vtree-root');

    this.createTreeGroups(this.d3.g, 0);

    visitAfter(this.root, (node) => {
      node.render(node.g);

      const layout = node.layout || this.defaultLayout;

      layout.layout(node);

      if (layout.renderLinks) {
        layout.renderLinks(node);
      }
    });

    if (this._debug) {
      visitAfter(this.root, (node) => {
        this._debugDrawNodeInfo(node);
      });
    }


    this.setRootPos();

    return this;
  }

  setRootPos() {
    this.root.x = Math.round((this._width - this.root.width) / 2);
    this.root.y = Math.round((this._height - this.root.totalHeight) / 2);

    if (this.root.y < MARGIN) {
      this.root.y = MARGIN;
    }

    this.root.g.attr('transform', `translate(${this.root.x},${this.root.y})`);

  }

  _debugGetG() {
    if (!this._debug) {
      return;
    }

    var g = this.d3.svg.select('g.debug-info');

    if (!g.empty()) {
      return g;
    }

    return this.d3.svg.append('g')
      .attr('class', 'debug-info');
  }

  _debugDrawGrid() {
    if (!this._debug) {
      return;
    }

    const g = this._debugGetG();

    g.append('line')
      .style('stroke', 'red')
      .attr('x1', this._width / 2)
      .attr('y1', 0)
      .attr('x2', this._width / 2)
      .attr('y2', this._height);

    g.append('line')
      .style('stroke', 'red')
      .attr('x1', 0)
      .attr('y1', this._height / 2)
      .attr('x2', this._width)
      .attr('y2', this._height / 2);
  }

  _debugDrawNodeInfo(node) {
    if (node.constructor === ArrayNode) {
      return;
    }

    // node rect
    node.g.append('rect')
      .style('fill', 'none')
      .style('stroke', 'tomato')
      .attr('x', -1)
      .attr('y', -1)
      .attr('width', node.width + 2)
      .attr('height', node.height + 2);

    // node total rect
    node.g.append('rect')
      .style('fill', 'none')
      .style('stroke', 'mediumpurple')
      .attr('x', (node.width - node.totalWidth) / 2)
      .attr('y', 0)
      .attr('width', node.totalWidth)
      .attr('height', node.totalHeight);

    // x, y
    const xy = node.g.append('text')
      .text(`x=${node.x} y=${node.y}`);

    const bbox = xy.node().getBBox();
    var x = node.width / 2;
    var y = node.height + bbox.height + 2;

    xy
      .attr('x', x)
      .attr('y', y)
      .attr('text-anchor', 'middle');

    y += bbox.height + 2;

    // width, height
    node.g.append('text')
      .text(`w=${node.width} h=${node.height}`)
      .attr('x', x)
      .attr('y', y)
      .attr('text-anchor', 'middle');

    y += bbox.height + 2;

    // totalWidth, totalHeight
    node.g.append('text')
      .text(`tw=${node.totalWidth} th=${node.totalHeight}`)
      .attr('x', x)
      .attr('y', y)
      .attr('text-anchor', 'middle');

    y += bbox.height + 2;

    // childrenWidth
    node.g.append('text')
      .text(`cw=${node.childrenWidth}`)
      .attr('x', x)
      .attr('y', y)
      .attr('text-anchor', 'middle');
  }
}


VTree.node = {};
VTree.node.Node = Node;
VTree.node.String = StringNode;
VTree.node.Table = TableNode;
VTree.node.Array = ArrayNode;

VTree.layout = {};
VTree.layout.Tree = TreeLayout;
VTree.layout.Array = ArrayLayout;

VTree.reader = {};
VTree.reader.Object = ObjectReader;

module.exports = VTree;
