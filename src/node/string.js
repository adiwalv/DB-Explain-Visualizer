import Node from './node.js';
import { appendRectText } from './util.js';


export default class StringNode extends Node {
  constructor(data) {
    super(data, []);

    this.textPad = 4;
  }

  _render(g) {
    const bbox = appendRectText(g, 0, 0, this.data, this.textPad);

    this.width = bbox.width;
    this.height = bbox.height;

    this.linkX = Math.round(this.width / 2);
    this.linkY = Math.round(this.height / 2);
  }
}
