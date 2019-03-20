/* global d3 */

const DURATION = 1000;

const diagonal = d3.svg.diagonal();


export default class ArrayLayout {
  constructor(options={}) {
    this.hideLinks = options.hideLinks;
  }

  layout(node) {
    calcChildrenWidth(node);
    calcTotalSize(node);

    layout(node);
  }

  renderLinks(node) {
    if (!this.hideLinks) {
      renderLinks(node);
    }
  }
}


function layout(node) {
  if (node.children.length === 0) {
    return;
  }

  var x = -Math.round(node.childrenWidth / 2);
  const y = 0;

  node.children.forEach((child) => {
    child.x = x + Math.round(child.totalWidth / 2) - Math.round(child.width / 2);
    child.y = y;

    child.g
      .transition()
      .duration(DURATION)
      .attr('transform', `translate(${child.x},${child.y})`);

    x += child.totalWidth + node.margin;
  });
}


function renderLinks(node) {
  if (node.children.length === 0) {
    return;
  }

  var h = node.children[0].linkY;

  node.children.forEach((child) => {
    h = Math.min(h, child.linkY);
  });

  const orig = { x: 0, y: 0 };

  var i, src, dst;

  for (i = 0; i < node.children.length; i++) {
    if (i === 0) {
      continue;
    }

    const prev = node.children[i - 1];
    const child = node.children[i];

    src = {
      x: prev.x + prev.linkX,
      y: prev.y + h
    };

    dst = {
      x: child.x + child.linkX,
      y: child.y + h
    };

    const link = node.g.insert('path', ':first-child')
      .attr('class', 'vtree-link')
      .attr('d', function () {
        return diagonal({ source: orig, target: orig });
      });

    link
      .transition()
      .duration(DURATION)
      .attr('d', function () {
        return diagonal({ source: src, target: dst });
      });
  }
}


function calcChildrenWidth(node) {
  if (node.children.length === 0) {
    node.childrenWidth = 0;

    return;
  }

  var w = 0;

  node.children.forEach((child) => {
    w += child.totalWidth;
  });

  w += (node.children.length - 1) * node.margin;

  node.childrenWidth = w;
}


function calcTotalSize(node) {
  if (node.children.length === 0) {
    node.totalWidth = node.width;
    node.totalHeight = node.height;

    return;
  }

  node.totalWidth = Math.max(node.width, node.childrenWidth);

  var maxChildH = 0;

  node.children.forEach((child) => {
    maxChildH = Math.max(maxChildH, child.totalHeight);
  });

  node.totalHeight = maxChildH;
}
