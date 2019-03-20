import StringNode from '../node/string.js';
import ArrayNode from '../node/array.js';
import TableNode from '../node/table.js';
import DummyNode from '../node/dummy.js';

import LinkNameDecorator from '../decorator/linkName.js';


export default class ObjectReader {
  constructor() {
  }

  read(obj) {
    return obj2node(obj, '');
  }
}


function obj2node(obj, linkName) {
  var node;

  if (isPrimitive(obj)) {
    node = new StringNode(obj);
  } else if (Array.isArray(obj)) {
    const nodes = [];

    obj.forEach((item, i) => {
      if (Array.isArray(item)) {
        node = new DummyNode(obj2node(item, ''));
        node.decorators.push(new LinkNameDecorator(`${linkName}[${i}]`));
        nodes.push(node);
      } else {
        node = obj2node(item, `${linkName}[${i}]`);
        nodes.push(node);
      }
    });

    // empty array
    if (nodes.length === 0) {
      node = obj2node(null, `${linkName}[]`);
      nodes.push(node);
    }

    node = new ArrayNode(nodes);
  } else {
    var name;
    var tbl = [];
    var children = [];

    for (name in obj) {
      if (!obj.hasOwnProperty(name)) {
        continue;
      }

      var data = obj[name];

      if (isPrimitive(data)) {
        tbl.push([name, data]);
      } else {
        children.push(obj2node(data, name));
      }
    }

    if (tbl.length === 0) {
      node = new TableNode([[' ', ' ']], children);
    } else {
      node = new TableNode(tbl, children);
    }

  }

  if (linkName !== '' && node.constructor !== ArrayNode) {
    node.decorators.push(new LinkNameDecorator(linkName));
  }

  return node;
}


function isPrimitive(d) {
  const type = typeof d;

  if (d === null || type === 'string' || type === 'number' || type === 'boolean') {
    return true;
  }

  return false;
}
