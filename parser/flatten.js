#!/usr/bin/env node

const flat = require('./index.js')
const fs = require('fs')
const path = require('path')
const readline = require('readline')

  const file = path.resolve(process.cwd(), process.argv.slice(2)[0])
  if (!file) usage()
  if (!fs.existsSync(file)) usage()
  out(require(file))

function out (data) {
  //  console.log(JSON.stringify(flat(data)))
    //process.stdout.write(JSON.stringify(flat(data), null, 2))
    var obj = flat(data)
    var keys = Object.keys(obj)
    var values = Object.values(obj)
    var output = []
    var i = 0
    for( i = 0; i < keys.length; i++) {
        var temp = keys[i].concat(" = ", values[i],"<br>")
        output.push(temp)
    }
    for( i = 0; i < keys.length; i++) {
        console.log(output[i])
    }
}

function usage () {
  console.log(`
Usage:

node flatten.js foo.json
cat foo.json | node flatten.js
`)

  process.exit()
}
