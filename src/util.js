export function visitBefore(node, callback) {
  const nodes = [node];

  while (nodes.length !== 0) {
    node = nodes.pop();

    callback(node);

    const children = node.children;

    if (children) {
      var n = children.length;

      while (--n >= 0) {
        nodes.push(children[n]);
      }
    }
  }
}

export function visitAfter(node, callback) {
  const nodes = [node];
  const nodes2 = [];

  while (nodes.length !== 0) {
    node = nodes.pop();

    nodes2.push(node);

    const children = node.children;

    if (children) {
      var i = -1;
      const n = children.length;

      while (++i < n) {
        nodes.push(children[i]);
      }
    }
  }

  while (nodes2.length !== 0) {
    node = nodes2.pop();

    callback(node);
  }
}
