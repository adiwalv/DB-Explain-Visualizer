const pad = 4;

export default class LinkNameDecorator {
  constructor(linkName) {
    this.linkName = linkName;
  }

  render(g, oldG, width) {
    const t = g.append('text')
      .text(this.linkName);

    const b = t.node().getBBox();
    const textW = Math.ceil(b.width);
    const textH = Math.ceil(b.height);

    const textTotalW = textW + pad * 2;

    var newW = width;

    if (textTotalW > width) {
      newW = textTotalW;
    }

    const textTotalH = textH + pad;

    const dw = newW - width;
    const dh = textTotalH;
    const dx = Math.round(dw / 2);
    const dy = textTotalH;

    t
      .attr('x', Math.round(newW / 2))
      .attr('y', textH)
      .attr('text-anchor', 'middle');

    return { dx, dy, dw, dh };
  }
}
