/**
 * Node
 *
 * A tree consists of nodes and links.
 * A node consists of the following fields:
 *
 * - id : auto increment ID.
 * - data : data which may be displayed.
 *          The data format is determined by the renderer.
 * - children : children of the node
 */


var curMaxId = 0;

export default class Node {
  constructor(data, children, layout) {
    this.id = ++curMaxId;
    this.data = data;
    this.children = children;

    if (layout) {
      this.layout = layout;
    }

    this.width = 0;
    this.height = 0;

    this.decorators = [];
  }

  render(g) {
    if (this.decorators.length === 0) {
      this._render(g);
      return;
    }

    var prevG = g.append('g');
    this._render(prevG);

    this.decorators.forEach((decorator) => {
      const newG = g.append('g');

      const dbbox = decorator.render(newG, prevG, this.width, this.height);

      if (dbbox.dw || dbbox.dh) {
        this.width += dbbox.dw;
        this.height += dbbox.dh;
      }

      if (dbbox.dx || dbbox.dy) {
        prevG.attr('transform', `translate(${dbbox.dx},${dbbox.dy})`);

        this.linkX += dbbox.dx;
        this.linkY += dbbox.dy;
      }

      prevG = newG;
    });
  }

  _render() {
    throw new Error('[no overwride errror] _render is not implemented.');
  }
}
