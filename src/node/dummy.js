import Node from './node.js';


export default class DummyNode extends Node {
  constructor(child) {
    super(null, [child]);

    this.r = 4;
  }

  _render(g) {
    g.append('circle')
      .attr('cx', this.r)
      .attr('cy', this.r)
      .attr('r', this.r);

    this.width = this.r * 2;
    this.height = this.r * 2;

    this.linkX = this.r;
    this.linkY = this.r;
  }
}
