/* eslint-disable no-undef */

import Reader from '../object.js';

import StringNode from '../../node/string.js';
import ArrayNode from '../../node/array.js';
import TableNode from '../../node/table.js';
import DummyNode from '../../node/dummy.js';

import LinkNameDecorator from '../../decorator/linkName.js';


describe('test ObjectReader', function () {
  var r;

  beforeEach(function () {
    r = new Reader();
  });

  // read a primitive object

  it ('read a null', function () {
    var d = r.read(null);
    expect(d).to.be.instanceof(StringNode);
    expect(d.data).to.equal(null);
    expect(d.children).to.have.lengthOf(0);
  });

  it ('read a boolean', function () {
    var d = r.read(true);
    expect(d).to.be.instanceof(StringNode);
    expect(d.data).to.equal(true);
    expect(d.children).to.have.lengthOf(0);

    d = r.read(false);
    expect(d).to.be.instanceof(StringNode);
    expect(d.data).to.equal(false);
    expect(d.children).to.have.lengthOf(0);
  });

  it ('read a number', function () {
    var d = r.read(666);
    expect(d).to.be.instanceof(StringNode);
    expect(d.data).to.equal(666);
    expect(d.children).to.have.lengthOf(0);

    d = r.read(3.14);
    expect(d).to.be.instanceof(StringNode);
    expect(d.data).to.equal(3.14);
    expect(d.children).to.have.lengthOf(0);
  });

  it ('read a string', function () {
    var d = r.read('JK business');
    expect(d).to.be.instanceof(StringNode);
    expect(d.data).to.equal('JK business');
    expect(d.children).to.have.lengthOf(0);

    d = r.read('お茶漬け');
    expect(d).to.be.instanceof(StringNode);
    expect(d.data).to.equal('お茶漬け');
    expect(d.children).to.have.lengthOf(0);
  });

  // read a complex object

  it ('read an array', function () {
    var d = r.read([1, 2]);
    expect(d.data).to.equal(null);
    expect(d).to.be.instanceof(ArrayNode);
    expect(d.children).to.have.lengthOf(2);

    var c = d.children[0];
    expect(c).to.be.instanceof(StringNode);
    expect(c.data).to.equal(1);
    expect(c.children).to.have.lengthOf(0);

    c = d.children[1];
    expect(c).to.be.instanceof(StringNode);
    expect(c.data).to.equal(2);
    expect(c.children).to.have.lengthOf(0);
  });

  it ('read a nested array', function () {
    var d = r.read([1, [2, 3]]);
    expect(d.data).to.equal(null);
    expect(d).to.be.instanceof(ArrayNode);
    expect(d.children).to.have.lengthOf(2);

    var c = d.children[0];
    expect(c).to.be.instanceof(StringNode);
    expect(c.data).to.equal(1);
    expect(c.children).to.have.lengthOf(0);

    c = d.children[1];
    expect(c).to.be.instanceof(DummyNode);
    expect(c.data).to.eql(null);
    expect(c.children).to.have.lengthOf(1);

    d = c.children[0];
    expect(d).to.be.instanceof(ArrayNode);
    expect(d.data).to.equal(null);
    expect(d.children).to.have.lengthOf(2);

    c = d.children[0];
    expect(c).to.be.instanceof(StringNode);
    expect(c.data).to.equal(2);
    expect(c.children).to.have.lengthOf(0);

    c = d.children[1];
    expect(c).to.be.instanceof(StringNode);
    expect(c.data).to.equal(3);
    expect(c.children).to.have.lengthOf(0);
  });

  it ('read an object', function () {
    var d = r.read({
      x: 1,
      y: 2
    });

    expect(d).to.be.instanceof(TableNode);
    expect(d.data).to.eql([['x', 1], ['y', 2]]);
    expect(d.children).to.have.lengthOf(0);
  });

  it ('read a nested object', function () {
    var d = r.read({
      name: {
        first: 'Bob',
        last: 'Bach'
      },
      age: 24
    });

    expect(d).to.be.instanceof(TableNode);
    expect(d.data).to.eql([['age', 24]]);
    expect(d.children).to.have.lengthOf(1);

    var c = d.children[0];
    expect(c).to.be.instanceof(TableNode);
    expect(c.data).to.eql([['first', 'Bob'], ['last', 'Bach']]);
    expect(c.children).to.have.lengthOf(0);

    var deco = c.decorators[0];
    expect(deco).to.be.instanceof(LinkNameDecorator);
    expect(deco.linkName).to.equal('name');
  });

  it ('read a nested object with no parent data', function () {
    var d = r.read({
      name: {
        first: 'Bob',
        last: 'Bach'
      }
    });

    expect(d).to.be.instanceof(TableNode);
    expect(d.data).to.eql([[' ', ' ']]);
    expect(d.children).to.have.lengthOf(1);

    var c = d.children[0];
    expect(c).to.be.instanceof(TableNode);
    expect(c.data).to.eql([['first', 'Bob'], ['last', 'Bach']]);
    expect(c.children).to.have.lengthOf(0);

    var deco = c.decorators[0];
    expect(deco).to.be.instanceof(LinkNameDecorator);
    expect(deco.linkName).to.equal('name');
  });

  it ('read an array containing an object', function () {
    var d = r.read([1, {val: 4}]);
    expect(d.data).to.equal(null);
    expect(d).to.be.instanceof(ArrayNode);
    expect(d.children).to.have.lengthOf(2);

    var c = d.children[0];
    expect(c).to.be.instanceof(StringNode);
    expect(c.data).to.equal(1);
    expect(c.children).to.have.lengthOf(0);

    c = d.children[1];
    expect(c).to.be.instanceof(TableNode);
    expect(c.data).to.eql([['val', 4]]);
    expect(c.children).to.have.lengthOf(0);
  });

  it ('read an object containing an array', function () {
    var d = r.read({
      name: 'Mike',
      vals: [2, 4]
    });

    expect(d).to.be.instanceof(TableNode);
    expect(d.data).to.eql([['name', 'Mike']]);
    expect(d.children).to.have.lengthOf(1);

    var c = d.children[0];
    expect(c).to.be.instanceof(ArrayNode);
    expect(c.data).to.equal(null);
    expect(c.children).to.have.lengthOf(2);

    d = c.children[0];
    expect(d).to.be.instanceof(StringNode);
    expect(d.data).to.equal(2);
    expect(d.children).to.have.lengthOf(0);

    var deco = d.decorators[0];
    expect(deco).to.be.instanceof(LinkNameDecorator);
    expect(deco.linkName).to.equal('vals[0]');

    d = c.children[1];
    expect(d).to.be.instanceof(StringNode);
    expect(d.data).to.equal(4);
    expect(d.children).to.have.lengthOf(0);

    deco = d.decorators[0];
    expect(deco).to.be.instanceof(LinkNameDecorator);
    expect(deco.linkName).to.equal('vals[1]');
  });
});
