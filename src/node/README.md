# How to make a custom node

1. extend the Node class

```js
export default class MyNode extends Node {
  ...
}
```

2. create the constructor functio and call super in it.

```js
  constructor(data, children) {
    super(data, children);

    ...
  }
```

3. write a custom \_render function.
   And set this.width, this.height, this.linkX and this.linkY in it.
   (linkX, linkY) is a link coord.

```js
  _render(g) {

    ...

    this.width = ...;
    this.height = ...;

    this.linkX = ...;
    this.linkY = ...;
  }
```
