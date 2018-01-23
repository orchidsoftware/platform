(function () {
var mobile = (function () {
  'use strict';

  var noop = function () {
  };
  var noarg = function (f) {
    return function () {
      return f();
    };
  };
  var compose = function (fa, fb) {
    return function () {
      return fa(fb.apply(null, arguments));
    };
  };
  var constant = function (value) {
    return function () {
      return value;
    };
  };
  var identity = function (x) {
    return x;
  };
  var tripleEquals = function (a, b) {
    return a === b;
  };
  var curry = function (f) {
    var args = new Array(arguments.length - 1);
    for (var i = 1; i < arguments.length; i++)
      args[i - 1] = arguments[i];
    return function () {
      var newArgs = new Array(arguments.length);
      for (var j = 0; j < newArgs.length; j++)
        newArgs[j] = arguments[j];
      var all = args.concat(newArgs);
      return f.apply(null, all);
    };
  };
  var not = function (f) {
    return function () {
      return !f.apply(null, arguments);
    };
  };
  var die = function (msg) {
    return function () {
      throw new Error(msg);
    };
  };
  var apply = function (f) {
    return f();
  };
  var call = function (f) {
    f();
  };
  var never$1 = constant(false);
  var always$1 = constant(true);
  var $_dh3z58wbjcq8ha9h = {
    noop: noop,
    noarg: noarg,
    compose: compose,
    constant: constant,
    identity: identity,
    tripleEquals: tripleEquals,
    curry: curry,
    not: not,
    die: die,
    apply: apply,
    call: call,
    never: never$1,
    always: always$1
  };

  var never = $_dh3z58wbjcq8ha9h.never;
  var always = $_dh3z58wbjcq8ha9h.always;
  var none = function () {
    return NONE;
  };
  var NONE = function () {
    var eq = function (o) {
      return o.isNone();
    };
    var call = function (thunk) {
      return thunk();
    };
    var id = function (n) {
      return n;
    };
    var noop = function () {
    };
    var me = {
      fold: function (n, s) {
        return n();
      },
      is: never,
      isSome: never,
      isNone: always,
      getOr: id,
      getOrThunk: call,
      getOrDie: function (msg) {
        throw new Error(msg || 'error: getOrDie called on none.');
      },
      or: id,
      orThunk: call,
      map: none,
      ap: none,
      each: noop,
      bind: none,
      flatten: none,
      exists: never,
      forall: always,
      filter: none,
      equals: eq,
      equals_: eq,
      toArray: function () {
        return [];
      },
      toString: $_dh3z58wbjcq8ha9h.constant('none()')
    };
    if (Object.freeze)
      Object.freeze(me);
    return me;
  }();
  var some = function (a) {
    var constant_a = function () {
      return a;
    };
    var self = function () {
      return me;
    };
    var map = function (f) {
      return some(f(a));
    };
    var bind = function (f) {
      return f(a);
    };
    var me = {
      fold: function (n, s) {
        return s(a);
      },
      is: function (v) {
        return a === v;
      },
      isSome: always,
      isNone: never,
      getOr: constant_a,
      getOrThunk: constant_a,
      getOrDie: constant_a,
      or: self,
      orThunk: self,
      map: map,
      ap: function (optfab) {
        return optfab.fold(none, function (fab) {
          return some(fab(a));
        });
      },
      each: function (f) {
        f(a);
      },
      bind: bind,
      flatten: constant_a,
      exists: bind,
      forall: bind,
      filter: function (f) {
        return f(a) ? me : NONE;
      },
      equals: function (o) {
        return o.is(a);
      },
      equals_: function (o, elementEq) {
        return o.fold(never, function (b) {
          return elementEq(a, b);
        });
      },
      toArray: function () {
        return [a];
      },
      toString: function () {
        return 'some(' + a + ')';
      }
    };
    return me;
  };
  var from = function (value) {
    return value === null || value === undefined ? NONE : some(value);
  };
  var $_9m6n87wajcq8ha9e = {
    some: some,
    none: none,
    from: from
  };

  var rawIndexOf = function () {
    var pIndexOf = Array.prototype.indexOf;
    var fastIndex = function (xs, x) {
      return pIndexOf.call(xs, x);
    };
    var slowIndex = function (xs, x) {
      return slowIndexOf(xs, x);
    };
    return pIndexOf === undefined ? slowIndex : fastIndex;
  }();
  var indexOf = function (xs, x) {
    var r = rawIndexOf(xs, x);
    return r === -1 ? $_9m6n87wajcq8ha9e.none() : $_9m6n87wajcq8ha9e.some(r);
  };
  var contains$1 = function (xs, x) {
    return rawIndexOf(xs, x) > -1;
  };
  var exists = function (xs, pred) {
    return findIndex(xs, pred).isSome();
  };
  var range = function (num, f) {
    var r = [];
    for (var i = 0; i < num; i++) {
      r.push(f(i));
    }
    return r;
  };
  var chunk = function (array, size) {
    var r = [];
    for (var i = 0; i < array.length; i += size) {
      var s = array.slice(i, i + size);
      r.push(s);
    }
    return r;
  };
  var map = function (xs, f) {
    var len = xs.length;
    var r = new Array(len);
    for (var i = 0; i < len; i++) {
      var x = xs[i];
      r[i] = f(x, i, xs);
    }
    return r;
  };
  var each = function (xs, f) {
    for (var i = 0, len = xs.length; i < len; i++) {
      var x = xs[i];
      f(x, i, xs);
    }
  };
  var eachr = function (xs, f) {
    for (var i = xs.length - 1; i >= 0; i--) {
      var x = xs[i];
      f(x, i, xs);
    }
  };
  var partition = function (xs, pred) {
    var pass = [];
    var fail = [];
    for (var i = 0, len = xs.length; i < len; i++) {
      var x = xs[i];
      var arr = pred(x, i, xs) ? pass : fail;
      arr.push(x);
    }
    return {
      pass: pass,
      fail: fail
    };
  };
  var filter = function (xs, pred) {
    var r = [];
    for (var i = 0, len = xs.length; i < len; i++) {
      var x = xs[i];
      if (pred(x, i, xs)) {
        r.push(x);
      }
    }
    return r;
  };
  var groupBy = function (xs, f) {
    if (xs.length === 0) {
      return [];
    } else {
      var wasType = f(xs[0]);
      var r = [];
      var group = [];
      for (var i = 0, len = xs.length; i < len; i++) {
        var x = xs[i];
        var type = f(x);
        if (type !== wasType) {
          r.push(group);
          group = [];
        }
        wasType = type;
        group.push(x);
      }
      if (group.length !== 0) {
        r.push(group);
      }
      return r;
    }
  };
  var foldr = function (xs, f, acc) {
    eachr(xs, function (x) {
      acc = f(acc, x);
    });
    return acc;
  };
  var foldl = function (xs, f, acc) {
    each(xs, function (x) {
      acc = f(acc, x);
    });
    return acc;
  };
  var find = function (xs, pred) {
    for (var i = 0, len = xs.length; i < len; i++) {
      var x = xs[i];
      if (pred(x, i, xs)) {
        return $_9m6n87wajcq8ha9e.some(x);
      }
    }
    return $_9m6n87wajcq8ha9e.none();
  };
  var findIndex = function (xs, pred) {
    for (var i = 0, len = xs.length; i < len; i++) {
      var x = xs[i];
      if (pred(x, i, xs)) {
        return $_9m6n87wajcq8ha9e.some(i);
      }
    }
    return $_9m6n87wajcq8ha9e.none();
  };
  var slowIndexOf = function (xs, x) {
    for (var i = 0, len = xs.length; i < len; ++i) {
      if (xs[i] === x) {
        return i;
      }
    }
    return -1;
  };
  var push = Array.prototype.push;
  var flatten = function (xs) {
    var r = [];
    for (var i = 0, len = xs.length; i < len; ++i) {
      if (!Array.prototype.isPrototypeOf(xs[i]))
        throw new Error('Arr.flatten item ' + i + ' was not an array, input: ' + xs);
      push.apply(r, xs[i]);
    }
    return r;
  };
  var bind = function (xs, f) {
    var output = map(xs, f);
    return flatten(output);
  };
  var forall = function (xs, pred) {
    for (var i = 0, len = xs.length; i < len; ++i) {
      var x = xs[i];
      if (pred(x, i, xs) !== true) {
        return false;
      }
    }
    return true;
  };
  var equal = function (a1, a2) {
    return a1.length === a2.length && forall(a1, function (x, i) {
      return x === a2[i];
    });
  };
  var slice = Array.prototype.slice;
  var reverse = function (xs) {
    var r = slice.call(xs, 0);
    r.reverse();
    return r;
  };
  var difference = function (a1, a2) {
    return filter(a1, function (x) {
      return !contains$1(a2, x);
    });
  };
  var mapToObject = function (xs, f) {
    var r = {};
    for (var i = 0, len = xs.length; i < len; i++) {
      var x = xs[i];
      r[String(x)] = f(x, i);
    }
    return r;
  };
  var pure = function (x) {
    return [x];
  };
  var sort = function (xs, comparator) {
    var copy = slice.call(xs, 0);
    copy.sort(comparator);
    return copy;
  };
  var head = function (xs) {
    return xs.length === 0 ? $_9m6n87wajcq8ha9e.none() : $_9m6n87wajcq8ha9e.some(xs[0]);
  };
  var last = function (xs) {
    return xs.length === 0 ? $_9m6n87wajcq8ha9e.none() : $_9m6n87wajcq8ha9e.some(xs[xs.length - 1]);
  };
  var $_dojsh2w9jcq8ha93 = {
    map: map,
    each: each,
    eachr: eachr,
    partition: partition,
    filter: filter,
    groupBy: groupBy,
    indexOf: indexOf,
    foldr: foldr,
    foldl: foldl,
    find: find,
    findIndex: findIndex,
    flatten: flatten,
    bind: bind,
    forall: forall,
    exists: exists,
    contains: contains$1,
    equal: equal,
    reverse: reverse,
    chunk: chunk,
    difference: difference,
    mapToObject: mapToObject,
    pure: pure,
    sort: sort,
    range: range,
    head: head,
    last: last
  };

  var global = typeof window !== 'undefined' ? window : Function('return this;')();

  var path = function (parts, scope) {
    var o = scope !== undefined && scope !== null ? scope : global;
    for (var i = 0; i < parts.length && o !== undefined && o !== null; ++i)
      o = o[parts[i]];
    return o;
  };
  var resolve = function (p, scope) {
    var parts = p.split('.');
    return path(parts, scope);
  };
  var step = function (o, part) {
    if (o[part] === undefined || o[part] === null)
      o[part] = {};
    return o[part];
  };
  var forge = function (parts, target) {
    var o = target !== undefined ? target : global;
    for (var i = 0; i < parts.length; ++i)
      o = step(o, parts[i]);
    return o;
  };
  var namespace = function (name, target) {
    var parts = name.split('.');
    return forge(parts, target);
  };
  var $_9gpcnlwejcq8ha9m = {
    path: path,
    resolve: resolve,
    forge: forge,
    namespace: namespace
  };

  var unsafe = function (name, scope) {
    return $_9gpcnlwejcq8ha9m.resolve(name, scope);
  };
  var getOrDie = function (name, scope) {
    var actual = unsafe(name, scope);
    if (actual === undefined || actual === null)
      throw name + ' not available on this browser';
    return actual;
  };
  var $_dvuzfwwdjcq8ha9k = { getOrDie: getOrDie };

  var node = function () {
    var f = $_dvuzfwwdjcq8ha9k.getOrDie('Node');
    return f;
  };
  var compareDocumentPosition = function (a, b, match) {
    return (a.compareDocumentPosition(b) & match) !== 0;
  };
  var documentPositionPreceding = function (a, b) {
    return compareDocumentPosition(a, b, node().DOCUMENT_POSITION_PRECEDING);
  };
  var documentPositionContainedBy = function (a, b) {
    return compareDocumentPosition(a, b, node().DOCUMENT_POSITION_CONTAINED_BY);
  };
  var $_8upjz3wcjcq8ha9j = {
    documentPositionPreceding: documentPositionPreceding,
    documentPositionContainedBy: documentPositionContainedBy
  };

  var cached = function (f) {
    var called = false;
    var r;
    return function () {
      if (!called) {
        called = true;
        r = f.apply(null, arguments);
      }
      return r;
    };
  };
  var $_8mt73whjcq8ha9q = { cached: cached };

  var firstMatch = function (regexes, s) {
    for (var i = 0; i < regexes.length; i++) {
      var x = regexes[i];
      if (x.test(s))
        return x;
    }
    return undefined;
  };
  var find$1 = function (regexes, agent) {
    var r = firstMatch(regexes, agent);
    if (!r)
      return {
        major: 0,
        minor: 0
      };
    var group = function (i) {
      return Number(agent.replace(r, '$' + i));
    };
    return nu$1(group(1), group(2));
  };
  var detect$2 = function (versionRegexes, agent) {
    var cleanedAgent = String(agent).toLowerCase();
    if (versionRegexes.length === 0)
      return unknown$1();
    return find$1(versionRegexes, cleanedAgent);
  };
  var unknown$1 = function () {
    return nu$1(0, 0);
  };
  var nu$1 = function (major, minor) {
    return {
      major: major,
      minor: minor
    };
  };
  var $_8k1szowkjcq8haa3 = {
    nu: nu$1,
    detect: detect$2,
    unknown: unknown$1
  };

  var edge = 'Edge';
  var chrome = 'Chrome';
  var ie = 'IE';
  var opera = 'Opera';
  var firefox = 'Firefox';
  var safari = 'Safari';
  var isBrowser = function (name, current) {
    return function () {
      return current === name;
    };
  };
  var unknown = function () {
    return nu({
      current: undefined,
      version: $_8k1szowkjcq8haa3.unknown()
    });
  };
  var nu = function (info) {
    var current = info.current;
    var version = info.version;
    return {
      current: current,
      version: version,
      isEdge: isBrowser(edge, current),
      isChrome: isBrowser(chrome, current),
      isIE: isBrowser(ie, current),
      isOpera: isBrowser(opera, current),
      isFirefox: isBrowser(firefox, current),
      isSafari: isBrowser(safari, current)
    };
  };
  var $_1lly5cwjjcq8ha9s = {
    unknown: unknown,
    nu: nu,
    edge: $_dh3z58wbjcq8ha9h.constant(edge),
    chrome: $_dh3z58wbjcq8ha9h.constant(chrome),
    ie: $_dh3z58wbjcq8ha9h.constant(ie),
    opera: $_dh3z58wbjcq8ha9h.constant(opera),
    firefox: $_dh3z58wbjcq8ha9h.constant(firefox),
    safari: $_dh3z58wbjcq8ha9h.constant(safari)
  };

  var windows = 'Windows';
  var ios = 'iOS';
  var android = 'Android';
  var linux = 'Linux';
  var osx = 'OSX';
  var solaris = 'Solaris';
  var freebsd = 'FreeBSD';
  var isOS = function (name, current) {
    return function () {
      return current === name;
    };
  };
  var unknown$2 = function () {
    return nu$2({
      current: undefined,
      version: $_8k1szowkjcq8haa3.unknown()
    });
  };
  var nu$2 = function (info) {
    var current = info.current;
    var version = info.version;
    return {
      current: current,
      version: version,
      isWindows: isOS(windows, current),
      isiOS: isOS(ios, current),
      isAndroid: isOS(android, current),
      isOSX: isOS(osx, current),
      isLinux: isOS(linux, current),
      isSolaris: isOS(solaris, current),
      isFreeBSD: isOS(freebsd, current)
    };
  };
  var $_2mcu7ywljcq8haa5 = {
    unknown: unknown$2,
    nu: nu$2,
    windows: $_dh3z58wbjcq8ha9h.constant(windows),
    ios: $_dh3z58wbjcq8ha9h.constant(ios),
    android: $_dh3z58wbjcq8ha9h.constant(android),
    linux: $_dh3z58wbjcq8ha9h.constant(linux),
    osx: $_dh3z58wbjcq8ha9h.constant(osx),
    solaris: $_dh3z58wbjcq8ha9h.constant(solaris),
    freebsd: $_dh3z58wbjcq8ha9h.constant(freebsd)
  };

  var DeviceType = function (os, browser, userAgent) {
    var isiPad = os.isiOS() && /ipad/i.test(userAgent) === true;
    var isiPhone = os.isiOS() && !isiPad;
    var isAndroid3 = os.isAndroid() && os.version.major === 3;
    var isAndroid4 = os.isAndroid() && os.version.major === 4;
    var isTablet = isiPad || isAndroid3 || isAndroid4 && /mobile/i.test(userAgent) === true;
    var isTouch = os.isiOS() || os.isAndroid();
    var isPhone = isTouch && !isTablet;
    var iOSwebview = browser.isSafari() && os.isiOS() && /safari/i.test(userAgent) === false;
    return {
      isiPad: $_dh3z58wbjcq8ha9h.constant(isiPad),
      isiPhone: $_dh3z58wbjcq8ha9h.constant(isiPhone),
      isTablet: $_dh3z58wbjcq8ha9h.constant(isTablet),
      isPhone: $_dh3z58wbjcq8ha9h.constant(isPhone),
      isTouch: $_dh3z58wbjcq8ha9h.constant(isTouch),
      isAndroid: os.isAndroid,
      isiOS: os.isiOS,
      isWebView: $_dh3z58wbjcq8ha9h.constant(iOSwebview)
    };
  };

  var detect$3 = function (candidates, userAgent) {
    var agent = String(userAgent).toLowerCase();
    return $_dojsh2w9jcq8ha93.find(candidates, function (candidate) {
      return candidate.search(agent);
    });
  };
  var detectBrowser = function (browsers, userAgent) {
    return detect$3(browsers, userAgent).map(function (browser) {
      var version = $_8k1szowkjcq8haa3.detect(browser.versionRegexes, userAgent);
      return {
        current: browser.name,
        version: version
      };
    });
  };
  var detectOs = function (oses, userAgent) {
    return detect$3(oses, userAgent).map(function (os) {
      var version = $_8k1szowkjcq8haa3.detect(os.versionRegexes, userAgent);
      return {
        current: os.name,
        version: version
      };
    });
  };
  var $_dqpnmmwnjcq8haaa = {
    detectBrowser: detectBrowser,
    detectOs: detectOs
  };

  var addToStart = function (str, prefix) {
    return prefix + str;
  };
  var addToEnd = function (str, suffix) {
    return str + suffix;
  };
  var removeFromStart = function (str, numChars) {
    return str.substring(numChars);
  };
  var removeFromEnd = function (str, numChars) {
    return str.substring(0, str.length - numChars);
  };
  var $_fsvsmvwqjcq8haai = {
    addToStart: addToStart,
    addToEnd: addToEnd,
    removeFromStart: removeFromStart,
    removeFromEnd: removeFromEnd
  };

  var first = function (str, count) {
    return str.substr(0, count);
  };
  var last$1 = function (str, count) {
    return str.substr(str.length - count, str.length);
  };
  var head$1 = function (str) {
    return str === '' ? $_9m6n87wajcq8ha9e.none() : $_9m6n87wajcq8ha9e.some(str.substr(0, 1));
  };
  var tail = function (str) {
    return str === '' ? $_9m6n87wajcq8ha9e.none() : $_9m6n87wajcq8ha9e.some(str.substring(1));
  };
  var $_1hd5pkwrjcq8haaj = {
    first: first,
    last: last$1,
    head: head$1,
    tail: tail
  };

  var checkRange = function (str, substr, start) {
    if (substr === '')
      return true;
    if (str.length < substr.length)
      return false;
    var x = str.substr(start, start + substr.length);
    return x === substr;
  };
  var supplant = function (str, obj) {
    var isStringOrNumber = function (a) {
      var t = typeof a;
      return t === 'string' || t === 'number';
    };
    return str.replace(/\${([^{}]*)}/g, function (a, b) {
      var value = obj[b];
      return isStringOrNumber(value) ? value : a;
    });
  };
  var removeLeading = function (str, prefix) {
    return startsWith(str, prefix) ? $_fsvsmvwqjcq8haai.removeFromStart(str, prefix.length) : str;
  };
  var removeTrailing = function (str, prefix) {
    return endsWith(str, prefix) ? $_fsvsmvwqjcq8haai.removeFromEnd(str, prefix.length) : str;
  };
  var ensureLeading = function (str, prefix) {
    return startsWith(str, prefix) ? str : $_fsvsmvwqjcq8haai.addToStart(str, prefix);
  };
  var ensureTrailing = function (str, prefix) {
    return endsWith(str, prefix) ? str : $_fsvsmvwqjcq8haai.addToEnd(str, prefix);
  };
  var contains$2 = function (str, substr) {
    return str.indexOf(substr) !== -1;
  };
  var capitalize = function (str) {
    return $_1hd5pkwrjcq8haaj.head(str).bind(function (head) {
      return $_1hd5pkwrjcq8haaj.tail(str).map(function (tail) {
        return head.toUpperCase() + tail;
      });
    }).getOr(str);
  };
  var startsWith = function (str, prefix) {
    return checkRange(str, prefix, 0);
  };
  var endsWith = function (str, suffix) {
    return checkRange(str, suffix, str.length - suffix.length);
  };
  var trim = function (str) {
    return str.replace(/^\s+|\s+$/g, '');
  };
  var lTrim = function (str) {
    return str.replace(/^\s+/g, '');
  };
  var rTrim = function (str) {
    return str.replace(/\s+$/g, '');
  };
  var $_1llmbzwpjcq8haag = {
    supplant: supplant,
    startsWith: startsWith,
    removeLeading: removeLeading,
    removeTrailing: removeTrailing,
    ensureLeading: ensureLeading,
    ensureTrailing: ensureTrailing,
    endsWith: endsWith,
    contains: contains$2,
    trim: trim,
    lTrim: lTrim,
    rTrim: rTrim,
    capitalize: capitalize
  };

  var normalVersionRegex = /.*?version\/\ ?([0-9]+)\.([0-9]+).*/;
  var checkContains = function (target) {
    return function (uastring) {
      return $_1llmbzwpjcq8haag.contains(uastring, target);
    };
  };
  var browsers = [
    {
      name: 'Edge',
      versionRegexes: [/.*?edge\/ ?([0-9]+)\.([0-9]+)$/],
      search: function (uastring) {
        var monstrosity = $_1llmbzwpjcq8haag.contains(uastring, 'edge/') && $_1llmbzwpjcq8haag.contains(uastring, 'chrome') && $_1llmbzwpjcq8haag.contains(uastring, 'safari') && $_1llmbzwpjcq8haag.contains(uastring, 'applewebkit');
        return monstrosity;
      }
    },
    {
      name: 'Chrome',
      versionRegexes: [
        /.*?chrome\/([0-9]+)\.([0-9]+).*/,
        normalVersionRegex
      ],
      search: function (uastring) {
        return $_1llmbzwpjcq8haag.contains(uastring, 'chrome') && !$_1llmbzwpjcq8haag.contains(uastring, 'chromeframe');
      }
    },
    {
      name: 'IE',
      versionRegexes: [
        /.*?msie\ ?([0-9]+)\.([0-9]+).*/,
        /.*?rv:([0-9]+)\.([0-9]+).*/
      ],
      search: function (uastring) {
        return $_1llmbzwpjcq8haag.contains(uastring, 'msie') || $_1llmbzwpjcq8haag.contains(uastring, 'trident');
      }
    },
    {
      name: 'Opera',
      versionRegexes: [
        normalVersionRegex,
        /.*?opera\/([0-9]+)\.([0-9]+).*/
      ],
      search: checkContains('opera')
    },
    {
      name: 'Firefox',
      versionRegexes: [/.*?firefox\/\ ?([0-9]+)\.([0-9]+).*/],
      search: checkContains('firefox')
    },
    {
      name: 'Safari',
      versionRegexes: [
        normalVersionRegex,
        /.*?cpu os ([0-9]+)_([0-9]+).*/
      ],
      search: function (uastring) {
        return ($_1llmbzwpjcq8haag.contains(uastring, 'safari') || $_1llmbzwpjcq8haag.contains(uastring, 'mobile/')) && $_1llmbzwpjcq8haag.contains(uastring, 'applewebkit');
      }
    }
  ];
  var oses = [
    {
      name: 'Windows',
      search: checkContains('win'),
      versionRegexes: [/.*?windows\ nt\ ?([0-9]+)\.([0-9]+).*/]
    },
    {
      name: 'iOS',
      search: function (uastring) {
        return $_1llmbzwpjcq8haag.contains(uastring, 'iphone') || $_1llmbzwpjcq8haag.contains(uastring, 'ipad');
      },
      versionRegexes: [
        /.*?version\/\ ?([0-9]+)\.([0-9]+).*/,
        /.*cpu os ([0-9]+)_([0-9]+).*/,
        /.*cpu iphone os ([0-9]+)_([0-9]+).*/
      ]
    },
    {
      name: 'Android',
      search: checkContains('android'),
      versionRegexes: [/.*?android\ ?([0-9]+)\.([0-9]+).*/]
    },
    {
      name: 'OSX',
      search: checkContains('os x'),
      versionRegexes: [/.*?os\ x\ ?([0-9]+)_([0-9]+).*/]
    },
    {
      name: 'Linux',
      search: checkContains('linux'),
      versionRegexes: []
    },
    {
      name: 'Solaris',
      search: checkContains('sunos'),
      versionRegexes: []
    },
    {
      name: 'FreeBSD',
      search: checkContains('freebsd'),
      versionRegexes: []
    }
  ];
  var $_8wsek4wojcq8haac = {
    browsers: $_dh3z58wbjcq8ha9h.constant(browsers),
    oses: $_dh3z58wbjcq8ha9h.constant(oses)
  };

  var detect$1 = function (userAgent) {
    var browsers = $_8wsek4wojcq8haac.browsers();
    var oses = $_8wsek4wojcq8haac.oses();
    var browser = $_dqpnmmwnjcq8haaa.detectBrowser(browsers, userAgent).fold($_1lly5cwjjcq8ha9s.unknown, $_1lly5cwjjcq8ha9s.nu);
    var os = $_dqpnmmwnjcq8haaa.detectOs(oses, userAgent).fold($_2mcu7ywljcq8haa5.unknown, $_2mcu7ywljcq8haa5.nu);
    var deviceType = DeviceType(os, browser, userAgent);
    return {
      browser: browser,
      os: os,
      deviceType: deviceType
    };
  };
  var $_9968e6wijcq8ha9r = { detect: detect$1 };

  var detect = $_8mt73whjcq8ha9q.cached(function () {
    var userAgent = navigator.userAgent;
    return $_9968e6wijcq8ha9r.detect(userAgent);
  });
  var $_6a5cn8wgjcq8ha9o = { detect: detect };

  var fromHtml = function (html, scope) {
    var doc = scope || document;
    var div = doc.createElement('div');
    div.innerHTML = html;
    if (!div.hasChildNodes() || div.childNodes.length > 1) {
      console.error('HTML does not have a single root node', html);
      throw 'HTML must have a single root node';
    }
    return fromDom(div.childNodes[0]);
  };
  var fromTag = function (tag, scope) {
    var doc = scope || document;
    var node = doc.createElement(tag);
    return fromDom(node);
  };
  var fromText = function (text, scope) {
    var doc = scope || document;
    var node = doc.createTextNode(text);
    return fromDom(node);
  };
  var fromDom = function (node) {
    if (node === null || node === undefined)
      throw new Error('Node cannot be null or undefined');
    return { dom: $_dh3z58wbjcq8ha9h.constant(node) };
  };
  var fromPoint = function (doc, x, y) {
    return $_9m6n87wajcq8ha9e.from(doc.dom().elementFromPoint(x, y)).map(fromDom);
  };
  var $_1t8d5wwtjcq8haao = {
    fromHtml: fromHtml,
    fromTag: fromTag,
    fromText: fromText,
    fromDom: fromDom,
    fromPoint: fromPoint
  };

  var $_fs0lc9wujcq8haas = {
    ATTRIBUTE: 2,
    CDATA_SECTION: 4,
    COMMENT: 8,
    DOCUMENT: 9,
    DOCUMENT_TYPE: 10,
    DOCUMENT_FRAGMENT: 11,
    ELEMENT: 1,
    TEXT: 3,
    PROCESSING_INSTRUCTION: 7,
    ENTITY_REFERENCE: 5,
    ENTITY: 6,
    NOTATION: 12
  };

  var ELEMENT = $_fs0lc9wujcq8haas.ELEMENT;
  var DOCUMENT = $_fs0lc9wujcq8haas.DOCUMENT;
  var is = function (element, selector) {
    var elem = element.dom();
    if (elem.nodeType !== ELEMENT)
      return false;
    else if (elem.matches !== undefined)
      return elem.matches(selector);
    else if (elem.msMatchesSelector !== undefined)
      return elem.msMatchesSelector(selector);
    else if (elem.webkitMatchesSelector !== undefined)
      return elem.webkitMatchesSelector(selector);
    else if (elem.mozMatchesSelector !== undefined)
      return elem.mozMatchesSelector(selector);
    else
      throw new Error('Browser lacks native selectors');
  };
  var bypassSelector = function (dom) {
    return dom.nodeType !== ELEMENT && dom.nodeType !== DOCUMENT || dom.childElementCount === 0;
  };
  var all = function (selector, scope) {
    var base = scope === undefined ? document : scope.dom();
    return bypassSelector(base) ? [] : $_dojsh2w9jcq8ha93.map(base.querySelectorAll(selector), $_1t8d5wwtjcq8haao.fromDom);
  };
  var one = function (selector, scope) {
    var base = scope === undefined ? document : scope.dom();
    return bypassSelector(base) ? $_9m6n87wajcq8ha9e.none() : $_9m6n87wajcq8ha9e.from(base.querySelector(selector)).map($_1t8d5wwtjcq8haao.fromDom);
  };
  var $_eekfszwsjcq8haak = {
    all: all,
    is: is,
    one: one
  };

  var eq = function (e1, e2) {
    return e1.dom() === e2.dom();
  };
  var isEqualNode = function (e1, e2) {
    return e1.dom().isEqualNode(e2.dom());
  };
  var member = function (element, elements) {
    return $_dojsh2w9jcq8ha93.exists(elements, $_dh3z58wbjcq8ha9h.curry(eq, element));
  };
  var regularContains = function (e1, e2) {
    var d1 = e1.dom(), d2 = e2.dom();
    return d1 === d2 ? false : d1.contains(d2);
  };
  var ieContains = function (e1, e2) {
    return $_8upjz3wcjcq8ha9j.documentPositionContainedBy(e1.dom(), e2.dom());
  };
  var browser = $_6a5cn8wgjcq8ha9o.detect().browser;
  var contains = browser.isIE() ? ieContains : regularContains;
  var $_darej4w8jcq8ha8v = {
    eq: eq,
    isEqualNode: isEqualNode,
    member: member,
    contains: contains,
    is: $_eekfszwsjcq8haak.is
  };

  var isSource = function (component, simulatedEvent) {
    return $_darej4w8jcq8ha8v.eq(component.element(), simulatedEvent.event().target());
  };
  var $_ec1ypew7jcq8ha8s = { isSource: isSource };

  var $_gcr2umwxjcq8hab1 = {
    contextmenu: $_dh3z58wbjcq8ha9h.constant('contextmenu'),
    touchstart: $_dh3z58wbjcq8ha9h.constant('touchstart'),
    touchmove: $_dh3z58wbjcq8ha9h.constant('touchmove'),
    touchend: $_dh3z58wbjcq8ha9h.constant('touchend'),
    gesturestart: $_dh3z58wbjcq8ha9h.constant('gesturestart'),
    mousedown: $_dh3z58wbjcq8ha9h.constant('mousedown'),
    mousemove: $_dh3z58wbjcq8ha9h.constant('mousemove'),
    mouseout: $_dh3z58wbjcq8ha9h.constant('mouseout'),
    mouseup: $_dh3z58wbjcq8ha9h.constant('mouseup'),
    mouseover: $_dh3z58wbjcq8ha9h.constant('mouseover'),
    focusin: $_dh3z58wbjcq8ha9h.constant('focusin'),
    keydown: $_dh3z58wbjcq8ha9h.constant('keydown'),
    input: $_dh3z58wbjcq8ha9h.constant('input'),
    change: $_dh3z58wbjcq8ha9h.constant('change'),
    focus: $_dh3z58wbjcq8ha9h.constant('focus'),
    click: $_dh3z58wbjcq8ha9h.constant('click'),
    transitionend: $_dh3z58wbjcq8ha9h.constant('transitionend'),
    selectstart: $_dh3z58wbjcq8ha9h.constant('selectstart')
  };

  var alloy = { tap: $_dh3z58wbjcq8ha9h.constant('alloy.tap') };
  var $_51ilu1wwjcq8haax = {
    focus: $_dh3z58wbjcq8ha9h.constant('alloy.focus'),
    postBlur: $_dh3z58wbjcq8ha9h.constant('alloy.blur.post'),
    receive: $_dh3z58wbjcq8ha9h.constant('alloy.receive'),
    execute: $_dh3z58wbjcq8ha9h.constant('alloy.execute'),
    focusItem: $_dh3z58wbjcq8ha9h.constant('alloy.focus.item'),
    tap: alloy.tap,
    tapOrClick: $_6a5cn8wgjcq8ha9o.detect().deviceType.isTouch() ? alloy.tap : $_gcr2umwxjcq8hab1.click,
    longpress: $_dh3z58wbjcq8ha9h.constant('alloy.longpress'),
    sandboxClose: $_dh3z58wbjcq8ha9h.constant('alloy.sandbox.close'),
    systemInit: $_dh3z58wbjcq8ha9h.constant('alloy.system.init'),
    windowScroll: $_dh3z58wbjcq8ha9h.constant('alloy.system.scroll'),
    attachedToDom: $_dh3z58wbjcq8ha9h.constant('alloy.system.attached'),
    detachedFromDom: $_dh3z58wbjcq8ha9h.constant('alloy.system.detached'),
    changeTab: $_dh3z58wbjcq8ha9h.constant('alloy.change.tab'),
    dismissTab: $_dh3z58wbjcq8ha9h.constant('alloy.dismiss.tab')
  };

  var typeOf = function (x) {
    if (x === null)
      return 'null';
    var t = typeof x;
    if (t === 'object' && Array.prototype.isPrototypeOf(x))
      return 'array';
    if (t === 'object' && String.prototype.isPrototypeOf(x))
      return 'string';
    return t;
  };
  var isType = function (type) {
    return function (value) {
      return typeOf(value) === type;
    };
  };
  var $_6xn7hbwzjcq8hab5 = {
    isString: isType('string'),
    isObject: isType('object'),
    isArray: isType('array'),
    isNull: isType('null'),
    isBoolean: isType('boolean'),
    isUndefined: isType('undefined'),
    isFunction: isType('function'),
    isNumber: isType('number')
  };

  var shallow = function (old, nu) {
    return nu;
  };
  var deep = function (old, nu) {
    var bothObjects = $_6xn7hbwzjcq8hab5.isObject(old) && $_6xn7hbwzjcq8hab5.isObject(nu);
    return bothObjects ? deepMerge(old, nu) : nu;
  };
  var baseMerge = function (merger) {
    return function () {
      var objects = new Array(arguments.length);
      for (var i = 0; i < objects.length; i++)
        objects[i] = arguments[i];
      if (objects.length === 0)
        throw new Error('Can\'t merge zero objects');
      var ret = {};
      for (var j = 0; j < objects.length; j++) {
        var curObject = objects[j];
        for (var key in curObject)
          if (curObject.hasOwnProperty(key)) {
            ret[key] = merger(ret[key], curObject[key]);
          }
      }
      return ret;
    };
  };
  var deepMerge = baseMerge(deep);
  var merge = baseMerge(shallow);
  var $_936c00wyjcq8hab3 = {
    deepMerge: deepMerge,
    merge: merge
  };

  var keys = function () {
    var fastKeys = Object.keys;
    var slowKeys = function (o) {
      var r = [];
      for (var i in o) {
        if (o.hasOwnProperty(i)) {
          r.push(i);
        }
      }
      return r;
    };
    return fastKeys === undefined ? slowKeys : fastKeys;
  }();
  var each$1 = function (obj, f) {
    var props = keys(obj);
    for (var k = 0, len = props.length; k < len; k++) {
      var i = props[k];
      var x = obj[i];
      f(x, i, obj);
    }
  };
  var objectMap = function (obj, f) {
    return tupleMap(obj, function (x, i, obj) {
      return {
        k: i,
        v: f(x, i, obj)
      };
    });
  };
  var tupleMap = function (obj, f) {
    var r = {};
    each$1(obj, function (x, i) {
      var tuple = f(x, i, obj);
      r[tuple.k] = tuple.v;
    });
    return r;
  };
  var bifilter = function (obj, pred) {
    var t = {};
    var f = {};
    each$1(obj, function (x, i) {
      var branch = pred(x, i) ? t : f;
      branch[i] = x;
    });
    return {
      t: t,
      f: f
    };
  };
  var mapToArray = function (obj, f) {
    var r = [];
    each$1(obj, function (value, name) {
      r.push(f(value, name));
    });
    return r;
  };
  var find$2 = function (obj, pred) {
    var props = keys(obj);
    for (var k = 0, len = props.length; k < len; k++) {
      var i = props[k];
      var x = obj[i];
      if (pred(x, i, obj)) {
        return $_9m6n87wajcq8ha9e.some(x);
      }
    }
    return $_9m6n87wajcq8ha9e.none();
  };
  var values = function (obj) {
    return mapToArray(obj, function (v) {
      return v;
    });
  };
  var size = function (obj) {
    return values(obj).length;
  };
  var $_et458cx0jcq8hab6 = {
    bifilter: bifilter,
    each: each$1,
    map: objectMap,
    mapToArray: mapToArray,
    tupleMap: tupleMap,
    find: find$2,
    keys: keys,
    values: values,
    size: size
  };

  var emit = function (component, event) {
    dispatchWith(component, component.element(), event, {});
  };
  var emitWith = function (component, event, properties) {
    dispatchWith(component, component.element(), event, properties);
  };
  var emitExecute = function (component) {
    emit(component, $_51ilu1wwjcq8haax.execute());
  };
  var dispatch = function (component, target, event) {
    dispatchWith(component, target, event, {});
  };
  var dispatchWith = function (component, target, event, properties) {
    var data = $_936c00wyjcq8hab3.deepMerge({ target: target }, properties);
    component.getSystem().triggerEvent(event, target, $_et458cx0jcq8hab6.map(data, $_dh3z58wbjcq8ha9h.constant));
  };
  var dispatchEvent = function (component, target, event, simulatedEvent) {
    component.getSystem().triggerEvent(event, target, simulatedEvent.event());
  };
  var dispatchFocus = function (component, target) {
    component.getSystem().triggerFocus(target, component.element());
  };
  var $_3yqf3awvjcq8haat = {
    emit: emit,
    emitWith: emitWith,
    emitExecute: emitExecute,
    dispatch: dispatch,
    dispatchWith: dispatchWith,
    dispatchEvent: dispatchEvent,
    dispatchFocus: dispatchFocus
  };

  var generate = function (cases) {
    if (!$_6xn7hbwzjcq8hab5.isArray(cases)) {
      throw new Error('cases must be an array');
    }
    if (cases.length === 0) {
      throw new Error('there must be at least one case');
    }
    var constructors = [];
    var adt = {};
    $_dojsh2w9jcq8ha93.each(cases, function (acase, count) {
      var keys = $_et458cx0jcq8hab6.keys(acase);
      if (keys.length !== 1) {
        throw new Error('one and only one name per case');
      }
      var key = keys[0];
      var value = acase[key];
      if (adt[key] !== undefined) {
        throw new Error('duplicate key detected:' + key);
      } else if (key === 'cata') {
        throw new Error('cannot have a case named cata (sorry)');
      } else if (!$_6xn7hbwzjcq8hab5.isArray(value)) {
        throw new Error('case arguments must be an array');
      }
      constructors.push(key);
      adt[key] = function () {
        var argLength = arguments.length;
        if (argLength !== value.length) {
          throw new Error('Wrong number of arguments to case ' + key + '. Expected ' + value.length + ' (' + value + '), got ' + argLength);
        }
        var args = new Array(argLength);
        for (var i = 0; i < args.length; i++)
          args[i] = arguments[i];
        var match = function (branches) {
          var branchKeys = $_et458cx0jcq8hab6.keys(branches);
          if (constructors.length !== branchKeys.length) {
            throw new Error('Wrong number of arguments to match. Expected: ' + constructors.join(',') + '\nActual: ' + branchKeys.join(','));
          }
          var allReqd = $_dojsh2w9jcq8ha93.forall(constructors, function (reqKey) {
            return $_dojsh2w9jcq8ha93.contains(branchKeys, reqKey);
          });
          if (!allReqd)
            throw new Error('Not all branches were specified when using match. Specified: ' + branchKeys.join(', ') + '\nRequired: ' + constructors.join(', '));
          return branches[key].apply(null, args);
        };
        return {
          fold: function () {
            if (arguments.length !== cases.length) {
              throw new Error('Wrong number of arguments to fold. Expected ' + cases.length + ', got ' + arguments.length);
            }
            var target = arguments[count];
            return target.apply(null, args);
          },
          match: match,
          log: function (label) {
            console.log(label, {
              constructors: constructors,
              constructor: key,
              params: args
            });
          }
        };
      };
    });
    return adt;
  };
  var $_dho4a6x4jcq8habz = { generate: generate };

  var adt = $_dho4a6x4jcq8habz.generate([
    { strict: [] },
    { defaultedThunk: ['fallbackThunk'] },
    { asOption: [] },
    { asDefaultedOptionThunk: ['fallbackThunk'] },
    { mergeWithThunk: ['baseThunk'] }
  ]);
  var defaulted$1 = function (fallback) {
    return adt.defaultedThunk($_dh3z58wbjcq8ha9h.constant(fallback));
  };
  var asDefaultedOption = function (fallback) {
    return adt.asDefaultedOptionThunk($_dh3z58wbjcq8ha9h.constant(fallback));
  };
  var mergeWith = function (base) {
    return adt.mergeWithThunk($_dh3z58wbjcq8ha9h.constant(base));
  };
  var $_27p6pex3jcq8habw = {
    strict: adt.strict,
    asOption: adt.asOption,
    defaulted: defaulted$1,
    defaultedThunk: adt.defaultedThunk,
    asDefaultedOption: asDefaultedOption,
    asDefaultedOptionThunk: adt.asDefaultedOptionThunk,
    mergeWith: mergeWith,
    mergeWithThunk: adt.mergeWithThunk
  };

  var value$1 = function (o) {
    var is = function (v) {
      return o === v;
    };
    var or = function (opt) {
      return value$1(o);
    };
    var orThunk = function (f) {
      return value$1(o);
    };
    var map = function (f) {
      return value$1(f(o));
    };
    var each = function (f) {
      f(o);
    };
    var bind = function (f) {
      return f(o);
    };
    var fold = function (_, onValue) {
      return onValue(o);
    };
    var exists = function (f) {
      return f(o);
    };
    var forall = function (f) {
      return f(o);
    };
    var toOption = function () {
      return $_9m6n87wajcq8ha9e.some(o);
    };
    return {
      is: is,
      isValue: $_dh3z58wbjcq8ha9h.constant(true),
      isError: $_dh3z58wbjcq8ha9h.constant(false),
      getOr: $_dh3z58wbjcq8ha9h.constant(o),
      getOrThunk: $_dh3z58wbjcq8ha9h.constant(o),
      getOrDie: $_dh3z58wbjcq8ha9h.constant(o),
      or: or,
      orThunk: orThunk,
      fold: fold,
      map: map,
      each: each,
      bind: bind,
      exists: exists,
      forall: forall,
      toOption: toOption
    };
  };
  var error = function (message) {
    var getOrThunk = function (f) {
      return f();
    };
    var getOrDie = function () {
      return $_dh3z58wbjcq8ha9h.die(message)();
    };
    var or = function (opt) {
      return opt;
    };
    var orThunk = function (f) {
      return f();
    };
    var map = function (f) {
      return error(message);
    };
    var bind = function (f) {
      return error(message);
    };
    var fold = function (onError, _) {
      return onError(message);
    };
    return {
      is: $_dh3z58wbjcq8ha9h.constant(false),
      isValue: $_dh3z58wbjcq8ha9h.constant(false),
      isError: $_dh3z58wbjcq8ha9h.constant(true),
      getOr: $_dh3z58wbjcq8ha9h.identity,
      getOrThunk: getOrThunk,
      getOrDie: getOrDie,
      or: or,
      orThunk: orThunk,
      fold: fold,
      map: map,
      each: $_dh3z58wbjcq8ha9h.noop,
      bind: bind,
      exists: $_dh3z58wbjcq8ha9h.constant(false),
      forall: $_dh3z58wbjcq8ha9h.constant(true),
      toOption: $_9m6n87wajcq8ha9e.none
    };
  };
  var $_yvshix8jcq8hacp = {
    value: value$1,
    error: error
  };

  var comparison = $_dho4a6x4jcq8habz.generate([
    {
      bothErrors: [
        'error1',
        'error2'
      ]
    },
    {
      firstError: [
        'error1',
        'value2'
      ]
    },
    {
      secondError: [
        'value1',
        'error2'
      ]
    },
    {
      bothValues: [
        'value1',
        'value2'
      ]
    }
  ]);
  var partition$1 = function (results) {
    var errors = [];
    var values = [];
    $_dojsh2w9jcq8ha93.each(results, function (result) {
      result.fold(function (err) {
        errors.push(err);
      }, function (value) {
        values.push(value);
      });
    });
    return {
      errors: errors,
      values: values
    };
  };
  var compare = function (result1, result2) {
    return result1.fold(function (err1) {
      return result2.fold(function (err2) {
        return comparison.bothErrors(err1, err2);
      }, function (val2) {
        return comparison.firstError(err1, val2);
      });
    }, function (val1) {
      return result2.fold(function (err2) {
        return comparison.secondError(val1, err2);
      }, function (val2) {
        return comparison.bothValues(val1, val2);
      });
    });
  };
  var $_83w0fux9jcq8hacs = {
    partition: partition$1,
    compare: compare
  };

  var mergeValues = function (values, base) {
    return $_yvshix8jcq8hacp.value($_936c00wyjcq8hab3.deepMerge.apply(undefined, [base].concat(values)));
  };
  var mergeErrors = function (errors) {
    return $_dh3z58wbjcq8ha9h.compose($_yvshix8jcq8hacp.error, $_dojsh2w9jcq8ha93.flatten)(errors);
  };
  var consolidateObj = function (objects, base) {
    var partitions = $_83w0fux9jcq8hacs.partition(objects);
    return partitions.errors.length > 0 ? mergeErrors(partitions.errors) : mergeValues(partitions.values, base);
  };
  var consolidateArr = function (objects) {
    var partitions = $_83w0fux9jcq8hacs.partition(objects);
    return partitions.errors.length > 0 ? mergeErrors(partitions.errors) : $_yvshix8jcq8hacp.value(partitions.values);
  };
  var $_85w5dox7jcq8hacj = {
    consolidateObj: consolidateObj,
    consolidateArr: consolidateArr
  };

  var narrow$1 = function (obj, fields) {
    var r = {};
    $_dojsh2w9jcq8ha93.each(fields, function (field) {
      if (obj[field] !== undefined && obj.hasOwnProperty(field))
        r[field] = obj[field];
    });
    return r;
  };
  var indexOnKey$1 = function (array, key) {
    var obj = {};
    $_dojsh2w9jcq8ha93.each(array, function (a) {
      var keyValue = a[key];
      obj[keyValue] = a;
    });
    return obj;
  };
  var exclude$1 = function (obj, fields) {
    var r = {};
    $_et458cx0jcq8hab6.each(obj, function (v, k) {
      if (!$_dojsh2w9jcq8ha93.contains(fields, k)) {
        r[k] = v;
      }
    });
    return r;
  };
  var $_6h0fl1xajcq8hact = {
    narrow: narrow$1,
    exclude: exclude$1,
    indexOnKey: indexOnKey$1
  };

  var readOpt$1 = function (key) {
    return function (obj) {
      return obj.hasOwnProperty(key) ? $_9m6n87wajcq8ha9e.from(obj[key]) : $_9m6n87wajcq8ha9e.none();
    };
  };
  var readOr$1 = function (key, fallback) {
    return function (obj) {
      return readOpt$1(key)(obj).getOr(fallback);
    };
  };
  var readOptFrom$1 = function (obj, key) {
    return readOpt$1(key)(obj);
  };
  var hasKey$1 = function (obj, key) {
    return obj.hasOwnProperty(key) && obj[key] !== undefined && obj[key] !== null;
  };
  var $_k6jtlxbjcq8hacx = {
    readOpt: readOpt$1,
    readOr: readOr$1,
    readOptFrom: readOptFrom$1,
    hasKey: hasKey$1
  };

  var wrap$1 = function (key, value) {
    var r = {};
    r[key] = value;
    return r;
  };
  var wrapAll$1 = function (keyvalues) {
    var r = {};
    $_dojsh2w9jcq8ha93.each(keyvalues, function (kv) {
      r[kv.key] = kv.value;
    });
    return r;
  };
  var $_dsqqfzxcjcq8hacz = {
    wrap: wrap$1,
    wrapAll: wrapAll$1
  };

  var narrow = function (obj, fields) {
    return $_6h0fl1xajcq8hact.narrow(obj, fields);
  };
  var exclude = function (obj, fields) {
    return $_6h0fl1xajcq8hact.exclude(obj, fields);
  };
  var readOpt = function (key) {
    return $_k6jtlxbjcq8hacx.readOpt(key);
  };
  var readOr = function (key, fallback) {
    return $_k6jtlxbjcq8hacx.readOr(key, fallback);
  };
  var readOptFrom = function (obj, key) {
    return $_k6jtlxbjcq8hacx.readOptFrom(obj, key);
  };
  var wrap = function (key, value) {
    return $_dsqqfzxcjcq8hacz.wrap(key, value);
  };
  var wrapAll = function (keyvalues) {
    return $_dsqqfzxcjcq8hacz.wrapAll(keyvalues);
  };
  var indexOnKey = function (array, key) {
    return $_6h0fl1xajcq8hact.indexOnKey(array, key);
  };
  var consolidate = function (objs, base) {
    return $_85w5dox7jcq8hacj.consolidateObj(objs, base);
  };
  var hasKey = function (obj, key) {
    return $_k6jtlxbjcq8hacx.hasKey(obj, key);
  };
  var $_f2tmkex6jcq8hach = {
    narrow: narrow,
    exclude: exclude,
    readOpt: readOpt,
    readOr: readOr,
    readOptFrom: readOptFrom,
    wrap: wrap,
    wrapAll: wrapAll,
    indexOnKey: indexOnKey,
    hasKey: hasKey,
    consolidate: consolidate
  };

  var json = function () {
    return $_dvuzfwwdjcq8ha9k.getOrDie('JSON');
  };
  var parse = function (obj) {
    return json().parse(obj);
  };
  var stringify = function (obj, replacer, space) {
    return json().stringify(obj, replacer, space);
  };
  var $_2k7xfnxfjcq8had9 = {
    parse: parse,
    stringify: stringify
  };

  var formatObj = function (input) {
    return $_6xn7hbwzjcq8hab5.isObject(input) && $_et458cx0jcq8hab6.keys(input).length > 100 ? ' removed due to size' : $_2k7xfnxfjcq8had9.stringify(input, null, 2);
  };
  var formatErrors = function (errors) {
    var es = errors.length > 10 ? errors.slice(0, 10).concat([{
        path: [],
        getErrorInfo: function () {
          return '... (only showing first ten failures)';
        }
      }]) : errors;
    return $_dojsh2w9jcq8ha93.map(es, function (e) {
      return 'Failed path: (' + e.path.join(' > ') + ')\n' + e.getErrorInfo();
    });
  };
  var $_dx81b0xejcq8had4 = {
    formatObj: formatObj,
    formatErrors: formatErrors
  };

  var nu$4 = function (path, getErrorInfo) {
    return $_yvshix8jcq8hacp.error([{
        path: path,
        getErrorInfo: getErrorInfo
      }]);
  };
  var missingStrict = function (path, key, obj) {
    return nu$4(path, function () {
      return 'Could not find valid *strict* value for "' + key + '" in ' + $_dx81b0xejcq8had4.formatObj(obj);
    });
  };
  var missingKey = function (path, key) {
    return nu$4(path, function () {
      return 'Choice schema did not contain choice key: "' + key + '"';
    });
  };
  var missingBranch = function (path, branches, branch) {
    return nu$4(path, function () {
      return 'The chosen schema: "' + branch + '" did not exist in branches: ' + $_dx81b0xejcq8had4.formatObj(branches);
    });
  };
  var unsupportedFields = function (path, unsupported) {
    return nu$4(path, function () {
      return 'There are unsupported fields: [' + unsupported.join(', ') + '] specified';
    });
  };
  var custom = function (path, err) {
    return nu$4(path, function () {
      return err;
    });
  };
  var toString = function (error) {
    return 'Failed path: (' + error.path.join(' > ') + ')\n' + error.getErrorInfo();
  };
  var $_7vejnxxdjcq8had1 = {
    missingStrict: missingStrict,
    missingKey: missingKey,
    missingBranch: missingBranch,
    unsupportedFields: unsupportedFields,
    custom: custom,
    toString: toString
  };

  var typeAdt = $_dho4a6x4jcq8habz.generate([
    {
      setOf: [
        'validator',
        'valueType'
      ]
    },
    { arrOf: ['valueType'] },
    { objOf: ['fields'] },
    { itemOf: ['validator'] },
    {
      choiceOf: [
        'key',
        'branches'
      ]
    }
  ]);
  var fieldAdt = $_dho4a6x4jcq8habz.generate([
    {
      field: [
        'name',
        'presence',
        'type'
      ]
    },
    { state: ['name'] }
  ]);
  var $_fj5zqnxgjcq8hada = {
    typeAdt: typeAdt,
    fieldAdt: fieldAdt
  };

  var adt$1 = $_dho4a6x4jcq8habz.generate([
    {
      field: [
        'key',
        'okey',
        'presence',
        'prop'
      ]
    },
    {
      state: [
        'okey',
        'instantiator'
      ]
    }
  ]);
  var output = function (okey, value) {
    return adt$1.state(okey, $_dh3z58wbjcq8ha9h.constant(value));
  };
  var snapshot = function (okey) {
    return adt$1.state(okey, $_dh3z58wbjcq8ha9h.identity);
  };
  var strictAccess = function (path, obj, key) {
    return $_k6jtlxbjcq8hacx.readOptFrom(obj, key).fold(function () {
      return $_7vejnxxdjcq8had1.missingStrict(path, key, obj);
    }, $_yvshix8jcq8hacp.value);
  };
  var fallbackAccess = function (obj, key, fallbackThunk) {
    var v = $_k6jtlxbjcq8hacx.readOptFrom(obj, key).fold(function () {
      return fallbackThunk(obj);
    }, $_dh3z58wbjcq8ha9h.identity);
    return $_yvshix8jcq8hacp.value(v);
  };
  var optionAccess = function (obj, key) {
    return $_yvshix8jcq8hacp.value($_k6jtlxbjcq8hacx.readOptFrom(obj, key));
  };
  var optionDefaultedAccess = function (obj, key, fallback) {
    var opt = $_k6jtlxbjcq8hacx.readOptFrom(obj, key).map(function (val) {
      return val === true ? fallback(obj) : val;
    });
    return $_yvshix8jcq8hacp.value(opt);
  };
  var cExtractOne = function (path, obj, field, strength) {
    return field.fold(function (key, okey, presence, prop) {
      var bundle = function (av) {
        return prop.extract(path.concat([key]), strength, av).map(function (res) {
          return $_dsqqfzxcjcq8hacz.wrap(okey, strength(res));
        });
      };
      var bundleAsOption = function (optValue) {
        return optValue.fold(function () {
          var outcome = $_dsqqfzxcjcq8hacz.wrap(okey, strength($_9m6n87wajcq8ha9e.none()));
          return $_yvshix8jcq8hacp.value(outcome);
        }, function (ov) {
          return prop.extract(path.concat([key]), strength, ov).map(function (res) {
            return $_dsqqfzxcjcq8hacz.wrap(okey, strength($_9m6n87wajcq8ha9e.some(res)));
          });
        });
      };
      return function () {
        return presence.fold(function () {
          return strictAccess(path, obj, key).bind(bundle);
        }, function (fallbackThunk) {
          return fallbackAccess(obj, key, fallbackThunk).bind(bundle);
        }, function () {
          return optionAccess(obj, key).bind(bundleAsOption);
        }, function (fallbackThunk) {
          return optionDefaultedAccess(obj, key, fallbackThunk).bind(bundleAsOption);
        }, function (baseThunk) {
          var base = baseThunk(obj);
          return fallbackAccess(obj, key, $_dh3z58wbjcq8ha9h.constant({})).map(function (v) {
            return $_936c00wyjcq8hab3.deepMerge(base, v);
          }).bind(bundle);
        });
      }();
    }, function (okey, instantiator) {
      var state = instantiator(obj);
      return $_yvshix8jcq8hacp.value($_dsqqfzxcjcq8hacz.wrap(okey, strength(state)));
    });
  };
  var cExtract = function (path, obj, fields, strength) {
    var results = $_dojsh2w9jcq8ha93.map(fields, function (field) {
      return cExtractOne(path, obj, field, strength);
    });
    return $_85w5dox7jcq8hacj.consolidateObj(results, {});
  };
  var value = function (validator) {
    var extract = function (path, strength, val) {
      return validator(val).fold(function (err) {
        return $_7vejnxxdjcq8had1.custom(path, err);
      }, $_yvshix8jcq8hacp.value);
    };
    var toString = function () {
      return 'val';
    };
    var toDsl = function () {
      return $_fj5zqnxgjcq8hada.typeAdt.itemOf(validator);
    };
    return {
      extract: extract,
      toString: toString,
      toDsl: toDsl
    };
  };
  var getSetKeys = function (obj) {
    var keys = $_et458cx0jcq8hab6.keys(obj);
    return $_dojsh2w9jcq8ha93.filter(keys, function (k) {
      return $_f2tmkex6jcq8hach.hasKey(obj, k);
    });
  };
  var objOnly = function (fields) {
    var delegate = obj(fields);
    var fieldNames = $_dojsh2w9jcq8ha93.foldr(fields, function (acc, f) {
      return f.fold(function (key) {
        return $_936c00wyjcq8hab3.deepMerge(acc, $_f2tmkex6jcq8hach.wrap(key, true));
      }, $_dh3z58wbjcq8ha9h.constant(acc));
    }, {});
    var extract = function (path, strength, o) {
      var keys = $_6xn7hbwzjcq8hab5.isBoolean(o) ? [] : getSetKeys(o);
      var extra = $_dojsh2w9jcq8ha93.filter(keys, function (k) {
        return !$_f2tmkex6jcq8hach.hasKey(fieldNames, k);
      });
      return extra.length === 0 ? delegate.extract(path, strength, o) : $_7vejnxxdjcq8had1.unsupportedFields(path, extra);
    };
    return {
      extract: extract,
      toString: delegate.toString,
      toDsl: delegate.toDsl
    };
  };
  var obj = function (fields) {
    var extract = function (path, strength, o) {
      return cExtract(path, o, fields, strength);
    };
    var toString = function () {
      var fieldStrings = $_dojsh2w9jcq8ha93.map(fields, function (field) {
        return field.fold(function (key, okey, presence, prop) {
          return key + ' -> ' + prop.toString();
        }, function (okey, instantiator) {
          return 'state(' + okey + ')';
        });
      });
      return 'obj{\n' + fieldStrings.join('\n') + '}';
    };
    var toDsl = function () {
      return $_fj5zqnxgjcq8hada.typeAdt.objOf($_dojsh2w9jcq8ha93.map(fields, function (f) {
        return f.fold(function (key, okey, presence, prop) {
          return $_fj5zqnxgjcq8hada.fieldAdt.field(key, presence, prop);
        }, function (okey, instantiator) {
          return $_fj5zqnxgjcq8hada.fieldAdt.state(okey);
        });
      }));
    };
    return {
      extract: extract,
      toString: toString,
      toDsl: toDsl
    };
  };
  var arr = function (prop) {
    var extract = function (path, strength, array) {
      var results = $_dojsh2w9jcq8ha93.map(array, function (a, i) {
        return prop.extract(path.concat(['[' + i + ']']), strength, a);
      });
      return $_85w5dox7jcq8hacj.consolidateArr(results);
    };
    var toString = function () {
      return 'array(' + prop.toString() + ')';
    };
    var toDsl = function () {
      return $_fj5zqnxgjcq8hada.typeAdt.arrOf(prop);
    };
    return {
      extract: extract,
      toString: toString,
      toDsl: toDsl
    };
  };
  var setOf = function (validator, prop) {
    var validateKeys = function (path, keys) {
      return arr(value(validator)).extract(path, $_dh3z58wbjcq8ha9h.identity, keys);
    };
    var extract = function (path, strength, o) {
      var keys = $_et458cx0jcq8hab6.keys(o);
      return validateKeys(path, keys).bind(function (validKeys) {
        var schema = $_dojsh2w9jcq8ha93.map(validKeys, function (vk) {
          return adt$1.field(vk, vk, $_27p6pex3jcq8habw.strict(), prop);
        });
        return obj(schema).extract(path, strength, o);
      });
    };
    var toString = function () {
      return 'setOf(' + prop.toString() + ')';
    };
    var toDsl = function () {
      return $_fj5zqnxgjcq8hada.typeAdt.setOf(validator, prop);
    };
    return {
      extract: extract,
      toString: toString,
      toDsl: toDsl
    };
  };
  var anyValue = value($_yvshix8jcq8hacp.value);
  var arrOfObj = $_dh3z58wbjcq8ha9h.compose(arr, obj);
  var $_9h3w6tx5jcq8hac3 = {
    anyValue: $_dh3z58wbjcq8ha9h.constant(anyValue),
    value: value,
    obj: obj,
    objOnly: objOnly,
    arr: arr,
    setOf: setOf,
    arrOfObj: arrOfObj,
    state: adt$1.state,
    field: adt$1.field,
    output: output,
    snapshot: snapshot
  };

  var strict = function (key) {
    return $_9h3w6tx5jcq8hac3.field(key, key, $_27p6pex3jcq8habw.strict(), $_9h3w6tx5jcq8hac3.anyValue());
  };
  var strictOf = function (key, schema) {
    return $_9h3w6tx5jcq8hac3.field(key, key, $_27p6pex3jcq8habw.strict(), schema);
  };
  var strictFunction = function (key) {
    return $_9h3w6tx5jcq8hac3.field(key, key, $_27p6pex3jcq8habw.strict(), $_9h3w6tx5jcq8hac3.value(function (f) {
      return $_6xn7hbwzjcq8hab5.isFunction(f) ? $_yvshix8jcq8hacp.value(f) : $_yvshix8jcq8hacp.error('Not a function');
    }));
  };
  var forbid = function (key, message) {
    return $_9h3w6tx5jcq8hac3.field(key, key, $_27p6pex3jcq8habw.asOption(), $_9h3w6tx5jcq8hac3.value(function (v) {
      return $_yvshix8jcq8hacp.error('The field: ' + key + ' is forbidden. ' + message);
    }));
  };
  var strictArrayOf = function (key, prop) {
    return strictOf(key, prop);
  };
  var strictObjOf = function (key, objSchema) {
    return $_9h3w6tx5jcq8hac3.field(key, key, $_27p6pex3jcq8habw.strict(), $_9h3w6tx5jcq8hac3.obj(objSchema));
  };
  var strictArrayOfObj = function (key, objFields) {
    return $_9h3w6tx5jcq8hac3.field(key, key, $_27p6pex3jcq8habw.strict(), $_9h3w6tx5jcq8hac3.arrOfObj(objFields));
  };
  var option = function (key) {
    return $_9h3w6tx5jcq8hac3.field(key, key, $_27p6pex3jcq8habw.asOption(), $_9h3w6tx5jcq8hac3.anyValue());
  };
  var optionOf = function (key, schema) {
    return $_9h3w6tx5jcq8hac3.field(key, key, $_27p6pex3jcq8habw.asOption(), schema);
  };
  var optionObjOf = function (key, objSchema) {
    return $_9h3w6tx5jcq8hac3.field(key, key, $_27p6pex3jcq8habw.asOption(), $_9h3w6tx5jcq8hac3.obj(objSchema));
  };
  var optionObjOfOnly = function (key, objSchema) {
    return $_9h3w6tx5jcq8hac3.field(key, key, $_27p6pex3jcq8habw.asOption(), $_9h3w6tx5jcq8hac3.objOnly(objSchema));
  };
  var defaulted = function (key, fallback) {
    return $_9h3w6tx5jcq8hac3.field(key, key, $_27p6pex3jcq8habw.defaulted(fallback), $_9h3w6tx5jcq8hac3.anyValue());
  };
  var defaultedOf = function (key, fallback, schema) {
    return $_9h3w6tx5jcq8hac3.field(key, key, $_27p6pex3jcq8habw.defaulted(fallback), schema);
  };
  var defaultedObjOf = function (key, fallback, objSchema) {
    return $_9h3w6tx5jcq8hac3.field(key, key, $_27p6pex3jcq8habw.defaulted(fallback), $_9h3w6tx5jcq8hac3.obj(objSchema));
  };
  var field = function (key, okey, presence, prop) {
    return $_9h3w6tx5jcq8hac3.field(key, okey, presence, prop);
  };
  var state = function (okey, instantiator) {
    return $_9h3w6tx5jcq8hac3.state(okey, instantiator);
  };
  var $_ah67nix2jcq8habi = {
    strict: strict,
    strictOf: strictOf,
    strictObjOf: strictObjOf,
    strictArrayOf: strictArrayOf,
    strictArrayOfObj: strictArrayOfObj,
    strictFunction: strictFunction,
    forbid: forbid,
    option: option,
    optionOf: optionOf,
    optionObjOf: optionObjOf,
    optionObjOfOnly: optionObjOfOnly,
    defaulted: defaulted,
    defaultedOf: defaultedOf,
    defaultedObjOf: defaultedObjOf,
    field: field,
    state: state
  };

  var chooseFrom = function (path, strength, input, branches, ch) {
    var fields = $_f2tmkex6jcq8hach.readOptFrom(branches, ch);
    return fields.fold(function () {
      return $_7vejnxxdjcq8had1.missingBranch(path, branches, ch);
    }, function (fs) {
      return $_9h3w6tx5jcq8hac3.obj(fs).extract(path.concat(['branch: ' + ch]), strength, input);
    });
  };
  var choose$1 = function (key, branches) {
    var extract = function (path, strength, input) {
      var choice = $_f2tmkex6jcq8hach.readOptFrom(input, key);
      return choice.fold(function () {
        return $_7vejnxxdjcq8had1.missingKey(path, key);
      }, function (chosen) {
        return chooseFrom(path, strength, input, branches, chosen);
      });
    };
    var toString = function () {
      return 'chooseOn(' + key + '). Possible values: ' + $_et458cx0jcq8hab6.keys(branches);
    };
    var toDsl = function () {
      return $_fj5zqnxgjcq8hada.typeAdt.choiceOf(key, branches);
    };
    return {
      extract: extract,
      toString: toString,
      toDsl: toDsl
    };
  };
  var $_bjmnxwxijcq8haio = { choose: choose$1 };

  var anyValue$1 = $_9h3w6tx5jcq8hac3.value($_yvshix8jcq8hacp.value);
  var arrOfObj$1 = function (objFields) {
    return $_9h3w6tx5jcq8hac3.arrOfObj(objFields);
  };
  var arrOfVal = function () {
    return $_9h3w6tx5jcq8hac3.arr(anyValue$1);
  };
  var arrOf = $_9h3w6tx5jcq8hac3.arr;
  var objOf = $_9h3w6tx5jcq8hac3.obj;
  var objOfOnly = $_9h3w6tx5jcq8hac3.objOnly;
  var setOf$1 = $_9h3w6tx5jcq8hac3.setOf;
  var valueOf = function (validator) {
    return $_9h3w6tx5jcq8hac3.value(validator);
  };
  var extract = function (label, prop, strength, obj) {
    return prop.extract([label], strength, obj).fold(function (errs) {
      return $_yvshix8jcq8hacp.error({
        input: obj,
        errors: errs
      });
    }, $_yvshix8jcq8hacp.value);
  };
  var asStruct = function (label, prop, obj) {
    return extract(label, prop, $_dh3z58wbjcq8ha9h.constant, obj);
  };
  var asRaw = function (label, prop, obj) {
    return extract(label, prop, $_dh3z58wbjcq8ha9h.identity, obj);
  };
  var getOrDie$1 = function (extraction) {
    return extraction.fold(function (errInfo) {
      throw new Error(formatError(errInfo));
    }, $_dh3z58wbjcq8ha9h.identity);
  };
  var asRawOrDie = function (label, prop, obj) {
    return getOrDie$1(asRaw(label, prop, obj));
  };
  var asStructOrDie = function (label, prop, obj) {
    return getOrDie$1(asStruct(label, prop, obj));
  };
  var formatError = function (errInfo) {
    return 'Errors: \n' + $_dx81b0xejcq8had4.formatErrors(errInfo.errors) + '\n\nInput object: ' + $_dx81b0xejcq8had4.formatObj(errInfo.input);
  };
  var choose = function (key, branches) {
    return $_bjmnxwxijcq8haio.choose(key, branches);
  };
  var $_g540acxhjcq8hadd = {
    anyValue: $_dh3z58wbjcq8ha9h.constant(anyValue$1),
    arrOfObj: arrOfObj$1,
    arrOf: arrOf,
    arrOfVal: arrOfVal,
    valueOf: valueOf,
    setOf: setOf$1,
    objOf: objOf,
    objOfOnly: objOfOnly,
    asStruct: asStruct,
    asRaw: asRaw,
    asStructOrDie: asStructOrDie,
    asRawOrDie: asRawOrDie,
    getOrDie: getOrDie$1,
    formatError: formatError,
    choose: choose
  };

  var nu$3 = function (parts) {
    if (!$_f2tmkex6jcq8hach.hasKey(parts, 'can') && !$_f2tmkex6jcq8hach.hasKey(parts, 'abort') && !$_f2tmkex6jcq8hach.hasKey(parts, 'run'))
      throw new Error('EventHandler defined by: ' + $_2k7xfnxfjcq8had9.stringify(parts, null, 2) + ' does not have can, abort, or run!');
    return $_g540acxhjcq8hadd.asRawOrDie('Extracting event.handler', $_g540acxhjcq8hadd.objOfOnly([
      $_ah67nix2jcq8habi.defaulted('can', $_dh3z58wbjcq8ha9h.constant(true)),
      $_ah67nix2jcq8habi.defaulted('abort', $_dh3z58wbjcq8ha9h.constant(false)),
      $_ah67nix2jcq8habi.defaulted('run', $_dh3z58wbjcq8ha9h.noop)
    ]), parts);
  };
  var all$1 = function (handlers, f) {
    return function () {
      var args = Array.prototype.slice.call(arguments, 0);
      return $_dojsh2w9jcq8ha93.foldl(handlers, function (acc, handler) {
        return acc && f(handler).apply(undefined, args);
      }, true);
    };
  };
  var any = function (handlers, f) {
    return function () {
      var args = Array.prototype.slice.call(arguments, 0);
      return $_dojsh2w9jcq8ha93.foldl(handlers, function (acc, handler) {
        return acc || f(handler).apply(undefined, args);
      }, false);
    };
  };
  var read = function (handler) {
    return $_6xn7hbwzjcq8hab5.isFunction(handler) ? {
      can: $_dh3z58wbjcq8ha9h.constant(true),
      abort: $_dh3z58wbjcq8ha9h.constant(false),
      run: handler
    } : handler;
  };
  var fuse = function (handlers) {
    var can = all$1(handlers, function (handler) {
      return handler.can;
    });
    var abort = any(handlers, function (handler) {
      return handler.abort;
    });
    var run = function () {
      var args = Array.prototype.slice.call(arguments, 0);
      $_dojsh2w9jcq8ha93.each(handlers, function (handler) {
        handler.run.apply(undefined, args);
      });
    };
    return nu$3({
      can: can,
      abort: abort,
      run: run
    });
  };
  var $_2wdanjx1jcq8hab9 = {
    read: read,
    fuse: fuse,
    nu: nu$3
  };

  var derive$1 = $_f2tmkex6jcq8hach.wrapAll;
  var abort = function (name, predicate) {
    return {
      key: name,
      value: $_2wdanjx1jcq8hab9.nu({ abort: predicate })
    };
  };
  var can = function (name, predicate) {
    return {
      key: name,
      value: $_2wdanjx1jcq8hab9.nu({ can: predicate })
    };
  };
  var preventDefault = function (name) {
    return {
      key: name,
      value: $_2wdanjx1jcq8hab9.nu({
        run: function (component, simulatedEvent) {
          simulatedEvent.event().prevent();
        }
      })
    };
  };
  var run = function (name, handler) {
    return {
      key: name,
      value: $_2wdanjx1jcq8hab9.nu({ run: handler })
    };
  };
  var runActionExtra = function (name, action, extra) {
    return {
      key: name,
      value: $_2wdanjx1jcq8hab9.nu({
        run: function (component) {
          action.apply(undefined, [component].concat(extra));
        }
      })
    };
  };
  var runOnName = function (name) {
    return function (handler) {
      return run(name, handler);
    };
  };
  var runOnSourceName = function (name) {
    return function (handler) {
      return {
        key: name,
        value: $_2wdanjx1jcq8hab9.nu({
          run: function (component, simulatedEvent) {
            if ($_ec1ypew7jcq8ha8s.isSource(component, simulatedEvent))
              handler(component, simulatedEvent);
          }
        })
      };
    };
  };
  var redirectToUid = function (name, uid) {
    return run(name, function (component, simulatedEvent) {
      component.getSystem().getByUid(uid).each(function (redirectee) {
        $_3yqf3awvjcq8haat.dispatchEvent(redirectee, redirectee.element(), name, simulatedEvent);
      });
    });
  };
  var redirectToPart = function (name, detail, partName) {
    var uid = detail.partUids()[partName];
    return redirectToUid(name, uid);
  };
  var runWithTarget = function (name, f) {
    return run(name, function (component, simulatedEvent) {
      component.getSystem().getByDom(simulatedEvent.event().target()).each(function (target) {
        f(component, target, simulatedEvent);
      });
    });
  };
  var cutter = function (name) {
    return run(name, function (component, simulatedEvent) {
      simulatedEvent.cut();
    });
  };
  var stopper = function (name) {
    return run(name, function (component, simulatedEvent) {
      simulatedEvent.stop();
    });
  };
  var $_dkbc99w6jcq8ha8p = {
    derive: derive$1,
    run: run,
    preventDefault: preventDefault,
    runActionExtra: runActionExtra,
    runOnAttached: runOnSourceName($_51ilu1wwjcq8haax.attachedToDom()),
    runOnDetached: runOnSourceName($_51ilu1wwjcq8haax.detachedFromDom()),
    runOnInit: runOnSourceName($_51ilu1wwjcq8haax.systemInit()),
    runOnExecute: runOnName($_51ilu1wwjcq8haax.execute()),
    redirectToUid: redirectToUid,
    redirectToPart: redirectToPart,
    runWithTarget: runWithTarget,
    abort: abort,
    can: can,
    cutter: cutter,
    stopper: stopper
  };

  var markAsBehaviourApi = function (f, apiName, apiFunction) {
    return f;
  };
  var markAsExtraApi = function (f, extraName) {
    return f;
  };
  var markAsSketchApi = function (f, apiFunction) {
    return f;
  };
  var getAnnotation = $_9m6n87wajcq8ha9e.none;
  var $_2ufx5exjjcq8haiz = {
    markAsBehaviourApi: markAsBehaviourApi,
    markAsExtraApi: markAsExtraApi,
    markAsSketchApi: markAsSketchApi,
    getAnnotation: getAnnotation
  };

  var Immutable = function () {
    var fields = arguments;
    return function () {
      var values = new Array(arguments.length);
      for (var i = 0; i < values.length; i++)
        values[i] = arguments[i];
      if (fields.length !== values.length)
        throw new Error('Wrong number of arguments to struct. Expected "[' + fields.length + ']", got ' + values.length + ' arguments');
      var struct = {};
      $_dojsh2w9jcq8ha93.each(fields, function (name, i) {
        struct[name] = $_dh3z58wbjcq8ha9h.constant(values[i]);
      });
      return struct;
    };
  };

  var sort$1 = function (arr) {
    return arr.slice(0).sort();
  };
  var reqMessage = function (required, keys) {
    throw new Error('All required keys (' + sort$1(required).join(', ') + ') were not specified. Specified keys were: ' + sort$1(keys).join(', ') + '.');
  };
  var unsuppMessage = function (unsupported) {
    throw new Error('Unsupported keys for object: ' + sort$1(unsupported).join(', '));
  };
  var validateStrArr = function (label, array) {
    if (!$_6xn7hbwzjcq8hab5.isArray(array))
      throw new Error('The ' + label + ' fields must be an array. Was: ' + array + '.');
    $_dojsh2w9jcq8ha93.each(array, function (a) {
      if (!$_6xn7hbwzjcq8hab5.isString(a))
        throw new Error('The value ' + a + ' in the ' + label + ' fields was not a string.');
    });
  };
  var invalidTypeMessage = function (incorrect, type) {
    throw new Error('All values need to be of type: ' + type + '. Keys (' + sort$1(incorrect).join(', ') + ') were not.');
  };
  var checkDupes = function (everything) {
    var sorted = sort$1(everything);
    var dupe = $_dojsh2w9jcq8ha93.find(sorted, function (s, i) {
      return i < sorted.length - 1 && s === sorted[i + 1];
    });
    dupe.each(function (d) {
      throw new Error('The field: ' + d + ' occurs more than once in the combined fields: [' + sorted.join(', ') + '].');
    });
  };
  var $_25xb1dxpjcq8haji = {
    sort: sort$1,
    reqMessage: reqMessage,
    unsuppMessage: unsuppMessage,
    validateStrArr: validateStrArr,
    invalidTypeMessage: invalidTypeMessage,
    checkDupes: checkDupes
  };

  var MixedBag = function (required, optional) {
    var everything = required.concat(optional);
    if (everything.length === 0)
      throw new Error('You must specify at least one required or optional field.');
    $_25xb1dxpjcq8haji.validateStrArr('required', required);
    $_25xb1dxpjcq8haji.validateStrArr('optional', optional);
    $_25xb1dxpjcq8haji.checkDupes(everything);
    return function (obj) {
      var keys = $_et458cx0jcq8hab6.keys(obj);
      var allReqd = $_dojsh2w9jcq8ha93.forall(required, function (req) {
        return $_dojsh2w9jcq8ha93.contains(keys, req);
      });
      if (!allReqd)
        $_25xb1dxpjcq8haji.reqMessage(required, keys);
      var unsupported = $_dojsh2w9jcq8ha93.filter(keys, function (key) {
        return !$_dojsh2w9jcq8ha93.contains(everything, key);
      });
      if (unsupported.length > 0)
        $_25xb1dxpjcq8haji.unsuppMessage(unsupported);
      var r = {};
      $_dojsh2w9jcq8ha93.each(required, function (req) {
        r[req] = $_dh3z58wbjcq8ha9h.constant(obj[req]);
      });
      $_dojsh2w9jcq8ha93.each(optional, function (opt) {
        r[opt] = $_dh3z58wbjcq8ha9h.constant(Object.prototype.hasOwnProperty.call(obj, opt) ? $_9m6n87wajcq8ha9e.some(obj[opt]) : $_9m6n87wajcq8ha9e.none());
      });
      return r;
    };
  };

  var $_4e5yxhxmjcq8hajd = {
    immutable: Immutable,
    immutableBag: MixedBag
  };

  var nu$6 = $_4e5yxhxmjcq8hajd.immutableBag(['tag'], [
    'classes',
    'attributes',
    'styles',
    'value',
    'innerHtml',
    'domChildren',
    'defChildren'
  ]);
  var defToStr = function (defn) {
    var raw = defToRaw(defn);
    return $_2k7xfnxfjcq8had9.stringify(raw, null, 2);
  };
  var defToRaw = function (defn) {
    return {
      tag: defn.tag(),
      classes: defn.classes().getOr([]),
      attributes: defn.attributes().getOr({}),
      styles: defn.styles().getOr({}),
      value: defn.value().getOr('<none>'),
      innerHtml: defn.innerHtml().getOr('<none>'),
      defChildren: defn.defChildren().getOr('<none>'),
      domChildren: defn.domChildren().fold(function () {
        return '<none>';
      }, function (children) {
        return children.length === 0 ? '0 children, but still specified' : String(children.length);
      })
    };
  };
  var $_an4dwdxljcq8haja = {
    nu: nu$6,
    defToStr: defToStr,
    defToRaw: defToRaw
  };

  var fields = [
    'classes',
    'attributes',
    'styles',
    'value',
    'innerHtml',
    'defChildren',
    'domChildren'
  ];
  var nu$5 = $_4e5yxhxmjcq8hajd.immutableBag([], fields);
  var derive$2 = function (settings) {
    var r = {};
    var keys = $_et458cx0jcq8hab6.keys(settings);
    $_dojsh2w9jcq8ha93.each(keys, function (key) {
      settings[key].each(function (v) {
        r[key] = v;
      });
    });
    return nu$5(r);
  };
  var modToStr = function (mod) {
    var raw = modToRaw(mod);
    return $_2k7xfnxfjcq8had9.stringify(raw, null, 2);
  };
  var modToRaw = function (mod) {
    return {
      classes: mod.classes().getOr('<none>'),
      attributes: mod.attributes().getOr('<none>'),
      styles: mod.styles().getOr('<none>'),
      value: mod.value().getOr('<none>'),
      innerHtml: mod.innerHtml().getOr('<none>'),
      defChildren: mod.defChildren().getOr('<none>'),
      domChildren: mod.domChildren().fold(function () {
        return '<none>';
      }, function (children) {
        return children.length === 0 ? '0 children, but still specified' : String(children.length);
      })
    };
  };
  var clashingOptArrays = function (key, oArr1, oArr2) {
    return oArr1.fold(function () {
      return oArr2.fold(function () {
        return {};
      }, function (arr2) {
        return $_f2tmkex6jcq8hach.wrap(key, arr2);
      });
    }, function (arr1) {
      return oArr2.fold(function () {
        return $_f2tmkex6jcq8hach.wrap(key, arr1);
      }, function (arr2) {
        return $_f2tmkex6jcq8hach.wrap(key, arr2);
      });
    });
  };
  var merge$1 = function (defnA, mod) {
    var raw = $_936c00wyjcq8hab3.deepMerge({
      tag: defnA.tag(),
      classes: mod.classes().getOr([]).concat(defnA.classes().getOr([])),
      attributes: $_936c00wyjcq8hab3.merge(defnA.attributes().getOr({}), mod.attributes().getOr({})),
      styles: $_936c00wyjcq8hab3.merge(defnA.styles().getOr({}), mod.styles().getOr({}))
    }, mod.innerHtml().or(defnA.innerHtml()).map(function (innerHtml) {
      return $_f2tmkex6jcq8hach.wrap('innerHtml', innerHtml);
    }).getOr({}), clashingOptArrays('domChildren', mod.domChildren(), defnA.domChildren()), clashingOptArrays('defChildren', mod.defChildren(), defnA.defChildren()), mod.value().or(defnA.value()).map(function (value) {
      return $_f2tmkex6jcq8hach.wrap('value', value);
    }).getOr({}));
    return $_an4dwdxljcq8haja.nu(raw);
  };
  var $_720ux0xkjcq8haj2 = {
    nu: nu$5,
    derive: derive$2,
    merge: merge$1,
    modToStr: modToStr,
    modToRaw: modToRaw
  };

  var executeEvent = function (bConfig, bState, executor) {
    return $_dkbc99w6jcq8ha8p.runOnExecute(function (component) {
      executor(component, bConfig, bState);
    });
  };
  var loadEvent = function (bConfig, bState, f) {
    return $_dkbc99w6jcq8ha8p.runOnInit(function (component, simulatedEvent) {
      f(component, bConfig, bState);
    });
  };
  var create$1 = function (schema, name, active, apis, extra, state) {
    var configSchema = $_g540acxhjcq8hadd.objOfOnly(schema);
    var schemaSchema = $_ah67nix2jcq8habi.optionObjOf(name, [$_ah67nix2jcq8habi.optionObjOfOnly('config', schema)]);
    return doCreate(configSchema, schemaSchema, name, active, apis, extra, state);
  };
  var createModes$1 = function (modes, name, active, apis, extra, state) {
    var configSchema = modes;
    var schemaSchema = $_ah67nix2jcq8habi.optionObjOf(name, [$_ah67nix2jcq8habi.optionOf('config', modes)]);
    return doCreate(configSchema, schemaSchema, name, active, apis, extra, state);
  };
  var wrapApi = function (bName, apiFunction, apiName) {
    var f = function (component) {
      var args = arguments;
      return component.config({ name: $_dh3z58wbjcq8ha9h.constant(bName) }).fold(function () {
        throw new Error('We could not find any behaviour configuration for: ' + bName + '. Using API: ' + apiName);
      }, function (info) {
        var rest = Array.prototype.slice.call(args, 1);
        return apiFunction.apply(undefined, [
          component,
          info.config,
          info.state
        ].concat(rest));
      });
    };
    return $_2ufx5exjjcq8haiz.markAsBehaviourApi(f, apiName, apiFunction);
  };
  var revokeBehaviour = function (name) {
    return {
      key: name,
      value: undefined
    };
  };
  var doCreate = function (configSchema, schemaSchema, name, active, apis, extra, state) {
    var getConfig = function (info) {
      return $_f2tmkex6jcq8hach.hasKey(info, name) ? info[name]() : $_9m6n87wajcq8ha9e.none();
    };
    var wrappedApis = $_et458cx0jcq8hab6.map(apis, function (apiF, apiName) {
      return wrapApi(name, apiF, apiName);
    });
    var wrappedExtra = $_et458cx0jcq8hab6.map(extra, function (extraF, extraName) {
      return $_2ufx5exjjcq8haiz.markAsExtraApi(extraF, extraName);
    });
    var me = $_936c00wyjcq8hab3.deepMerge(wrappedExtra, wrappedApis, {
      revoke: $_dh3z58wbjcq8ha9h.curry(revokeBehaviour, name),
      config: function (spec) {
        var prepared = $_g540acxhjcq8hadd.asStructOrDie(name + '-config', configSchema, spec);
        return {
          key: name,
          value: {
            config: prepared,
            me: me,
            configAsRaw: $_8mt73whjcq8ha9q.cached(function () {
              return $_g540acxhjcq8hadd.asRawOrDie(name + '-config', configSchema, spec);
            }),
            initialConfig: spec,
            state: state
          }
        };
      },
      schema: function () {
        return schemaSchema;
      },
      exhibit: function (info, base) {
        return getConfig(info).bind(function (behaviourInfo) {
          return $_f2tmkex6jcq8hach.readOptFrom(active, 'exhibit').map(function (exhibitor) {
            return exhibitor(base, behaviourInfo.config, behaviourInfo.state);
          });
        }).getOr($_720ux0xkjcq8haj2.nu({}));
      },
      name: function () {
        return name;
      },
      handlers: function (info) {
        return getConfig(info).bind(function (behaviourInfo) {
          return $_f2tmkex6jcq8hach.readOptFrom(active, 'events').map(function (events) {
            return events(behaviourInfo.config, behaviourInfo.state);
          });
        }).getOr({});
      }
    });
    return me;
  };
  var $_1oalwmw5jcq8ha8c = {
    executeEvent: executeEvent,
    loadEvent: loadEvent,
    create: create$1,
    createModes: createModes$1
  };

  var base = function (handleUnsupported, required) {
    return baseWith(handleUnsupported, required, {
      validate: $_6xn7hbwzjcq8hab5.isFunction,
      label: 'function'
    });
  };
  var baseWith = function (handleUnsupported, required, pred) {
    if (required.length === 0)
      throw new Error('You must specify at least one required field.');
    $_25xb1dxpjcq8haji.validateStrArr('required', required);
    $_25xb1dxpjcq8haji.checkDupes(required);
    return function (obj) {
      var keys = $_et458cx0jcq8hab6.keys(obj);
      var allReqd = $_dojsh2w9jcq8ha93.forall(required, function (req) {
        return $_dojsh2w9jcq8ha93.contains(keys, req);
      });
      if (!allReqd)
        $_25xb1dxpjcq8haji.reqMessage(required, keys);
      handleUnsupported(required, keys);
      var invalidKeys = $_dojsh2w9jcq8ha93.filter(required, function (key) {
        return !pred.validate(obj[key], key);
      });
      if (invalidKeys.length > 0)
        $_25xb1dxpjcq8haji.invalidTypeMessage(invalidKeys, pred.label);
      return obj;
    };
  };
  var handleExact = function (required, keys) {
    var unsupported = $_dojsh2w9jcq8ha93.filter(keys, function (key) {
      return !$_dojsh2w9jcq8ha93.contains(required, key);
    });
    if (unsupported.length > 0)
      $_25xb1dxpjcq8haji.unsuppMessage(unsupported);
  };
  var allowExtra = $_dh3z58wbjcq8ha9h.noop;
  var $_fg1gs2xsjcq8hajn = {
    exactly: $_dh3z58wbjcq8ha9h.curry(base, handleExact),
    ensure: $_dh3z58wbjcq8ha9h.curry(base, allowExtra),
    ensureWith: $_dh3z58wbjcq8ha9h.curry(baseWith, allowExtra)
  };

  var BehaviourState = $_fg1gs2xsjcq8hajn.ensure(['readState']);

  var init = function () {
    return BehaviourState({
      readState: function () {
        return 'No State required';
      }
    });
  };
  var $_6dyjy2xqjcq8hajl = { init: init };

  var derive = function (capabilities) {
    return $_f2tmkex6jcq8hach.wrapAll(capabilities);
  };
  var simpleSchema = $_g540acxhjcq8hadd.objOfOnly([
    $_ah67nix2jcq8habi.strict('fields'),
    $_ah67nix2jcq8habi.strict('name'),
    $_ah67nix2jcq8habi.defaulted('active', {}),
    $_ah67nix2jcq8habi.defaulted('apis', {}),
    $_ah67nix2jcq8habi.defaulted('extra', {}),
    $_ah67nix2jcq8habi.defaulted('state', $_6dyjy2xqjcq8hajl)
  ]);
  var create = function (data) {
    var value = $_g540acxhjcq8hadd.asRawOrDie('Creating behaviour: ' + data.name, simpleSchema, data);
    return $_1oalwmw5jcq8ha8c.create(value.fields, value.name, value.active, value.apis, value.extra, value.state);
  };
  var modeSchema = $_g540acxhjcq8hadd.objOfOnly([
    $_ah67nix2jcq8habi.strict('branchKey'),
    $_ah67nix2jcq8habi.strict('branches'),
    $_ah67nix2jcq8habi.strict('name'),
    $_ah67nix2jcq8habi.defaulted('active', {}),
    $_ah67nix2jcq8habi.defaulted('apis', {}),
    $_ah67nix2jcq8habi.defaulted('extra', {}),
    $_ah67nix2jcq8habi.defaulted('state', $_6dyjy2xqjcq8hajl)
  ]);
  var createModes = function (data) {
    var value = $_g540acxhjcq8hadd.asRawOrDie('Creating behaviour: ' + data.name, modeSchema, data);
    return $_1oalwmw5jcq8ha8c.createModes($_g540acxhjcq8hadd.choose(value.branchKey, value.branches), value.name, value.active, value.apis, value.extra, value.state);
  };
  var $_bfiithw4jcq8ha84 = {
    derive: derive,
    revoke: $_dh3z58wbjcq8ha9h.constant(undefined),
    noActive: $_dh3z58wbjcq8ha9h.constant({}),
    noApis: $_dh3z58wbjcq8ha9h.constant({}),
    noExtra: $_dh3z58wbjcq8ha9h.constant({}),
    noState: $_dh3z58wbjcq8ha9h.constant($_6dyjy2xqjcq8hajl),
    create: create,
    createModes: createModes
  };

  var Toggler = function (turnOff, turnOn, initial) {
    var active = initial || false;
    var on = function () {
      turnOn();
      active = true;
    };
    var off = function () {
      turnOff();
      active = false;
    };
    var toggle = function () {
      var f = active ? off : on;
      f();
    };
    var isOn = function () {
      return active;
    };
    return {
      on: on,
      off: off,
      toggle: toggle,
      isOn: isOn
    };
  };

  var name = function (element) {
    var r = element.dom().nodeName;
    return r.toLowerCase();
  };
  var type = function (element) {
    return element.dom().nodeType;
  };
  var value$2 = function (element) {
    return element.dom().nodeValue;
  };
  var isType$1 = function (t) {
    return function (element) {
      return type(element) === t;
    };
  };
  var isComment = function (element) {
    return type(element) === $_fs0lc9wujcq8haas.COMMENT || name(element) === '#comment';
  };
  var isElement = isType$1($_fs0lc9wujcq8haas.ELEMENT);
  var isText = isType$1($_fs0lc9wujcq8haas.TEXT);
  var isDocument = isType$1($_fs0lc9wujcq8haas.DOCUMENT);
  var $_4z03v7xxjcq8hak1 = {
    name: name,
    type: type,
    value: value$2,
    isElement: isElement,
    isText: isText,
    isDocument: isDocument,
    isComment: isComment
  };

  var rawSet = function (dom, key, value) {
    if ($_6xn7hbwzjcq8hab5.isString(value) || $_6xn7hbwzjcq8hab5.isBoolean(value) || $_6xn7hbwzjcq8hab5.isNumber(value)) {
      dom.setAttribute(key, value + '');
    } else {
      console.error('Invalid call to Attr.set. Key ', key, ':: Value ', value, ':: Element ', dom);
      throw new Error('Attribute value was not simple');
    }
  };
  var set = function (element, key, value) {
    rawSet(element.dom(), key, value);
  };
  var setAll = function (element, attrs) {
    var dom = element.dom();
    $_et458cx0jcq8hab6.each(attrs, function (v, k) {
      rawSet(dom, k, v);
    });
  };
  var get = function (element, key) {
    var v = element.dom().getAttribute(key);
    return v === null ? undefined : v;
  };
  var has$1 = function (element, key) {
    var dom = element.dom();
    return dom && dom.hasAttribute ? dom.hasAttribute(key) : false;
  };
  var remove$1 = function (element, key) {
    element.dom().removeAttribute(key);
  };
  var hasNone = function (element) {
    var attrs = element.dom().attributes;
    return attrs === undefined || attrs === null || attrs.length === 0;
  };
  var clone = function (element) {
    return $_dojsh2w9jcq8ha93.foldl(element.dom().attributes, function (acc, attr) {
      acc[attr.name] = attr.value;
      return acc;
    }, {});
  };
  var transferOne = function (source, destination, attr) {
    if (has$1(source, attr) && !has$1(destination, attr))
      set(destination, attr, get(source, attr));
  };
  var transfer = function (source, destination, attrs) {
    if (!$_4z03v7xxjcq8hak1.isElement(source) || !$_4z03v7xxjcq8hak1.isElement(destination))
      return;
    $_dojsh2w9jcq8ha93.each(attrs, function (attr) {
      transferOne(source, destination, attr);
    });
  };
  var $_3kyqh4xwjcq8hajw = {
    clone: clone,
    set: set,
    setAll: setAll,
    get: get,
    has: has$1,
    remove: remove$1,
    hasNone: hasNone,
    transfer: transfer
  };

  var read$1 = function (element, attr) {
    var value = $_3kyqh4xwjcq8hajw.get(element, attr);
    return value === undefined || value === '' ? [] : value.split(' ');
  };
  var add$2 = function (element, attr, id) {
    var old = read$1(element, attr);
    var nu = old.concat([id]);
    $_3kyqh4xwjcq8hajw.set(element, attr, nu.join(' '));
  };
  var remove$3 = function (element, attr, id) {
    var nu = $_dojsh2w9jcq8ha93.filter(read$1(element, attr), function (v) {
      return v !== id;
    });
    if (nu.length > 0)
      $_3kyqh4xwjcq8hajw.set(element, attr, nu.join(' '));
    else
      $_3kyqh4xwjcq8hajw.remove(element, attr);
  };
  var $_60eyijxzjcq8hak5 = {
    read: read$1,
    add: add$2,
    remove: remove$3
  };

  var supports = function (element) {
    return element.dom().classList !== undefined;
  };
  var get$1 = function (element) {
    return $_60eyijxzjcq8hak5.read(element, 'class');
  };
  var add$1 = function (element, clazz) {
    return $_60eyijxzjcq8hak5.add(element, 'class', clazz);
  };
  var remove$2 = function (element, clazz) {
    return $_60eyijxzjcq8hak5.remove(element, 'class', clazz);
  };
  var toggle$1 = function (element, clazz) {
    if ($_dojsh2w9jcq8ha93.contains(get$1(element), clazz)) {
      remove$2(element, clazz);
    } else {
      add$1(element, clazz);
    }
  };
  var $_5b5gdtxyjcq8hak3 = {
    get: get$1,
    add: add$1,
    remove: remove$2,
    toggle: toggle$1,
    supports: supports
  };

  var add = function (element, clazz) {
    if ($_5b5gdtxyjcq8hak3.supports(element))
      element.dom().classList.add(clazz);
    else
      $_5b5gdtxyjcq8hak3.add(element, clazz);
  };
  var cleanClass = function (element) {
    var classList = $_5b5gdtxyjcq8hak3.supports(element) ? element.dom().classList : $_5b5gdtxyjcq8hak3.get(element);
    if (classList.length === 0) {
      $_3kyqh4xwjcq8hajw.remove(element, 'class');
    }
  };
  var remove = function (element, clazz) {
    if ($_5b5gdtxyjcq8hak3.supports(element)) {
      var classList = element.dom().classList;
      classList.remove(clazz);
    } else
      $_5b5gdtxyjcq8hak3.remove(element, clazz);
    cleanClass(element);
  };
  var toggle = function (element, clazz) {
    return $_5b5gdtxyjcq8hak3.supports(element) ? element.dom().classList.toggle(clazz) : $_5b5gdtxyjcq8hak3.toggle(element, clazz);
  };
  var toggler = function (element, clazz) {
    var hasClasslist = $_5b5gdtxyjcq8hak3.supports(element);
    var classList = element.dom().classList;
    var off = function () {
      if (hasClasslist)
        classList.remove(clazz);
      else
        $_5b5gdtxyjcq8hak3.remove(element, clazz);
    };
    var on = function () {
      if (hasClasslist)
        classList.add(clazz);
      else
        $_5b5gdtxyjcq8hak3.add(element, clazz);
    };
    return Toggler(off, on, has(element, clazz));
  };
  var has = function (element, clazz) {
    return $_5b5gdtxyjcq8hak3.supports(element) && element.dom().classList.contains(clazz);
  };
  var $_waygfxujcq8hajt = {
    add: add,
    remove: remove,
    toggle: toggle,
    toggler: toggler,
    has: has
  };

  var swap = function (element, addCls, removeCls) {
    $_waygfxujcq8hajt.remove(element, removeCls);
    $_waygfxujcq8hajt.add(element, addCls);
  };
  var toAlpha = function (component, swapConfig, swapState) {
    swap(component.element(), swapConfig.alpha(), swapConfig.omega());
  };
  var toOmega = function (component, swapConfig, swapState) {
    swap(component.element(), swapConfig.omega(), swapConfig.alpha());
  };
  var clear = function (component, swapConfig, swapState) {
    $_waygfxujcq8hajt.remove(component.element(), swapConfig.alpha());
    $_waygfxujcq8hajt.remove(component.element(), swapConfig.omega());
  };
  var isAlpha = function (component, swapConfig, swapState) {
    return $_waygfxujcq8hajt.has(component.element(), swapConfig.alpha());
  };
  var isOmega = function (component, swapConfig, swapState) {
    return $_waygfxujcq8hajt.has(component.element(), swapConfig.omega());
  };
  var $_gcvw5hxtjcq8hajq = {
    toAlpha: toAlpha,
    toOmega: toOmega,
    isAlpha: isAlpha,
    isOmega: isOmega,
    clear: clear
  };

  var SwapSchema = [
    $_ah67nix2jcq8habi.strict('alpha'),
    $_ah67nix2jcq8habi.strict('omega')
  ];

  var Swapping = $_bfiithw4jcq8ha84.create({
    fields: SwapSchema,
    name: 'swapping',
    apis: $_gcvw5hxtjcq8hajq
  });

  var toArray = function (target, f) {
    var r = [];
    var recurse = function (e) {
      r.push(e);
      return f(e);
    };
    var cur = f(target);
    do {
      cur = cur.bind(recurse);
    } while (cur.isSome());
    return r;
  };
  var $_eqlk9my4jcq8hal0 = { toArray: toArray };

  var owner = function (element) {
    return $_1t8d5wwtjcq8haao.fromDom(element.dom().ownerDocument);
  };
  var documentElement = function (element) {
    var doc = owner(element);
    return $_1t8d5wwtjcq8haao.fromDom(doc.dom().documentElement);
  };
  var defaultView = function (element) {
    var el = element.dom();
    var defaultView = el.ownerDocument.defaultView;
    return $_1t8d5wwtjcq8haao.fromDom(defaultView);
  };
  var parent = function (element) {
    var dom = element.dom();
    return $_9m6n87wajcq8ha9e.from(dom.parentNode).map($_1t8d5wwtjcq8haao.fromDom);
  };
  var findIndex$1 = function (element) {
    return parent(element).bind(function (p) {
      var kin = children(p);
      return $_dojsh2w9jcq8ha93.findIndex(kin, function (elem) {
        return $_darej4w8jcq8ha8v.eq(element, elem);
      });
    });
  };
  var parents = function (element, isRoot) {
    var stop = $_6xn7hbwzjcq8hab5.isFunction(isRoot) ? isRoot : $_dh3z58wbjcq8ha9h.constant(false);
    var dom = element.dom();
    var ret = [];
    while (dom.parentNode !== null && dom.parentNode !== undefined) {
      var rawParent = dom.parentNode;
      var parent = $_1t8d5wwtjcq8haao.fromDom(rawParent);
      ret.push(parent);
      if (stop(parent) === true)
        break;
      else
        dom = rawParent;
    }
    return ret;
  };
  var siblings = function (element) {
    var filterSelf = function (elements) {
      return $_dojsh2w9jcq8ha93.filter(elements, function (x) {
        return !$_darej4w8jcq8ha8v.eq(element, x);
      });
    };
    return parent(element).map(children).map(filterSelf).getOr([]);
  };
  var offsetParent = function (element) {
    var dom = element.dom();
    return $_9m6n87wajcq8ha9e.from(dom.offsetParent).map($_1t8d5wwtjcq8haao.fromDom);
  };
  var prevSibling = function (element) {
    var dom = element.dom();
    return $_9m6n87wajcq8ha9e.from(dom.previousSibling).map($_1t8d5wwtjcq8haao.fromDom);
  };
  var nextSibling = function (element) {
    var dom = element.dom();
    return $_9m6n87wajcq8ha9e.from(dom.nextSibling).map($_1t8d5wwtjcq8haao.fromDom);
  };
  var prevSiblings = function (element) {
    return $_dojsh2w9jcq8ha93.reverse($_eqlk9my4jcq8hal0.toArray(element, prevSibling));
  };
  var nextSiblings = function (element) {
    return $_eqlk9my4jcq8hal0.toArray(element, nextSibling);
  };
  var children = function (element) {
    var dom = element.dom();
    return $_dojsh2w9jcq8ha93.map(dom.childNodes, $_1t8d5wwtjcq8haao.fromDom);
  };
  var child = function (element, index) {
    var children = element.dom().childNodes;
    return $_9m6n87wajcq8ha9e.from(children[index]).map($_1t8d5wwtjcq8haao.fromDom);
  };
  var firstChild = function (element) {
    return child(element, 0);
  };
  var lastChild = function (element) {
    return child(element, element.dom().childNodes.length - 1);
  };
  var childNodesCount = function (element) {
    return element.dom().childNodes.length;
  };
  var hasChildNodes = function (element) {
    return element.dom().hasChildNodes();
  };
  var spot = $_4e5yxhxmjcq8hajd.immutable('element', 'offset');
  var leaf = function (element, offset) {
    var cs = children(element);
    return cs.length > 0 && offset < cs.length ? spot(cs[offset], 0) : spot(element, offset);
  };
  var $_4h5j2xy3jcq8hakl = {
    owner: owner,
    defaultView: defaultView,
    documentElement: documentElement,
    parent: parent,
    findIndex: findIndex$1,
    parents: parents,
    siblings: siblings,
    prevSibling: prevSibling,
    offsetParent: offsetParent,
    prevSiblings: prevSiblings,
    nextSibling: nextSibling,
    nextSiblings: nextSiblings,
    children: children,
    child: child,
    firstChild: firstChild,
    lastChild: lastChild,
    childNodesCount: childNodesCount,
    hasChildNodes: hasChildNodes,
    leaf: leaf
  };

  var before = function (marker, element) {
    var parent = $_4h5j2xy3jcq8hakl.parent(marker);
    parent.each(function (v) {
      v.dom().insertBefore(element.dom(), marker.dom());
    });
  };
  var after = function (marker, element) {
    var sibling = $_4h5j2xy3jcq8hakl.nextSibling(marker);
    sibling.fold(function () {
      var parent = $_4h5j2xy3jcq8hakl.parent(marker);
      parent.each(function (v) {
        append(v, element);
      });
    }, function (v) {
      before(v, element);
    });
  };
  var prepend = function (parent, element) {
    var firstChild = $_4h5j2xy3jcq8hakl.firstChild(parent);
    firstChild.fold(function () {
      append(parent, element);
    }, function (v) {
      parent.dom().insertBefore(element.dom(), v.dom());
    });
  };
  var append = function (parent, element) {
    parent.dom().appendChild(element.dom());
  };
  var appendAt = function (parent, element, index) {
    $_4h5j2xy3jcq8hakl.child(parent, index).fold(function () {
      append(parent, element);
    }, function (v) {
      before(v, element);
    });
  };
  var wrap$2 = function (element, wrapper) {
    before(element, wrapper);
    append(wrapper, element);
  };
  var $_1lvp6jy2jcq8hakj = {
    before: before,
    after: after,
    prepend: prepend,
    append: append,
    appendAt: appendAt,
    wrap: wrap$2
  };

  var before$1 = function (marker, elements) {
    $_dojsh2w9jcq8ha93.each(elements, function (x) {
      $_1lvp6jy2jcq8hakj.before(marker, x);
    });
  };
  var after$1 = function (marker, elements) {
    $_dojsh2w9jcq8ha93.each(elements, function (x, i) {
      var e = i === 0 ? marker : elements[i - 1];
      $_1lvp6jy2jcq8hakj.after(e, x);
    });
  };
  var prepend$1 = function (parent, elements) {
    $_dojsh2w9jcq8ha93.each(elements.slice().reverse(), function (x) {
      $_1lvp6jy2jcq8hakj.prepend(parent, x);
    });
  };
  var append$1 = function (parent, elements) {
    $_dojsh2w9jcq8ha93.each(elements, function (x) {
      $_1lvp6jy2jcq8hakj.append(parent, x);
    });
  };
  var $_hk3r9y6jcq8hal3 = {
    before: before$1,
    after: after$1,
    prepend: prepend$1,
    append: append$1
  };

  var empty = function (element) {
    element.dom().textContent = '';
    $_dojsh2w9jcq8ha93.each($_4h5j2xy3jcq8hakl.children(element), function (rogue) {
      remove$4(rogue);
    });
  };
  var remove$4 = function (element) {
    var dom = element.dom();
    if (dom.parentNode !== null)
      dom.parentNode.removeChild(dom);
  };
  var unwrap = function (wrapper) {
    var children = $_4h5j2xy3jcq8hakl.children(wrapper);
    if (children.length > 0)
      $_hk3r9y6jcq8hal3.before(wrapper, children);
    remove$4(wrapper);
  };
  var $_axfxsny5jcq8hal1 = {
    empty: empty,
    remove: remove$4,
    unwrap: unwrap
  };

  var inBody = function (element) {
    var dom = $_4z03v7xxjcq8hak1.isText(element) ? element.dom().parentNode : element.dom();
    return dom !== undefined && dom !== null && dom.ownerDocument.body.contains(dom);
  };
  var body = $_8mt73whjcq8ha9q.cached(function () {
    return getBody($_1t8d5wwtjcq8haao.fromDom(document));
  });
  var getBody = function (doc) {
    var body = doc.dom().body;
    if (body === null || body === undefined)
      throw 'Body is not available yet';
    return $_1t8d5wwtjcq8haao.fromDom(body);
  };
  var $_4axtmsy7jcq8hal6 = {
    body: body,
    getBody: getBody,
    inBody: inBody
  };

  var fireDetaching = function (component) {
    $_3yqf3awvjcq8haat.emit(component, $_51ilu1wwjcq8haax.detachedFromDom());
    var children = component.components();
    $_dojsh2w9jcq8ha93.each(children, fireDetaching);
  };
  var fireAttaching = function (component) {
    var children = component.components();
    $_dojsh2w9jcq8ha93.each(children, fireAttaching);
    $_3yqf3awvjcq8haat.emit(component, $_51ilu1wwjcq8haax.attachedToDom());
  };
  var attach = function (parent, child) {
    attachWith(parent, child, $_1lvp6jy2jcq8hakj.append);
  };
  var attachWith = function (parent, child, insertion) {
    parent.getSystem().addToWorld(child);
    insertion(parent.element(), child.element());
    if ($_4axtmsy7jcq8hal6.inBody(parent.element()))
      fireAttaching(child);
    parent.syncComponents();
  };
  var doDetach = function (component) {
    fireDetaching(component);
    $_axfxsny5jcq8hal1.remove(component.element());
    component.getSystem().removeFromWorld(component);
  };
  var detach = function (component) {
    var parent = $_4h5j2xy3jcq8hakl.parent(component.element()).bind(function (p) {
      return component.getSystem().getByDom(p).fold($_9m6n87wajcq8ha9e.none, $_9m6n87wajcq8ha9e.some);
    });
    doDetach(component);
    parent.each(function (p) {
      p.syncComponents();
    });
  };
  var detachChildren = function (component) {
    var subs = component.components();
    $_dojsh2w9jcq8ha93.each(subs, doDetach);
    $_axfxsny5jcq8hal1.empty(component.element());
    component.syncComponents();
  };
  var attachSystem = function (element, guiSystem) {
    $_1lvp6jy2jcq8hakj.append(element, guiSystem.element());
    var children = $_4h5j2xy3jcq8hakl.children(guiSystem.element());
    $_dojsh2w9jcq8ha93.each(children, function (child) {
      guiSystem.getByDom(child).each(fireAttaching);
    });
  };
  var detachSystem = function (guiSystem) {
    var children = $_4h5j2xy3jcq8hakl.children(guiSystem.element());
    $_dojsh2w9jcq8ha93.each(children, function (child) {
      guiSystem.getByDom(child).each(fireDetaching);
    });
    $_axfxsny5jcq8hal1.remove(guiSystem.element());
  };
  var $_8oadbiy1jcq8haka = {
    attach: attach,
    attachWith: attachWith,
    detach: detach,
    detachChildren: detachChildren,
    attachSystem: attachSystem,
    detachSystem: detachSystem
  };

  var fromHtml$1 = function (html, scope) {
    var doc = scope || document;
    var div = doc.createElement('div');
    div.innerHTML = html;
    return $_4h5j2xy3jcq8hakl.children($_1t8d5wwtjcq8haao.fromDom(div));
  };
  var fromTags = function (tags, scope) {
    return $_dojsh2w9jcq8ha93.map(tags, function (x) {
      return $_1t8d5wwtjcq8haao.fromTag(x, scope);
    });
  };
  var fromText$1 = function (texts, scope) {
    return $_dojsh2w9jcq8ha93.map(texts, function (x) {
      return $_1t8d5wwtjcq8haao.fromText(x, scope);
    });
  };
  var fromDom$1 = function (nodes) {
    return $_dojsh2w9jcq8ha93.map(nodes, $_1t8d5wwtjcq8haao.fromDom);
  };
  var $_9ek449ycjcq8halu = {
    fromHtml: fromHtml$1,
    fromTags: fromTags,
    fromText: fromText$1,
    fromDom: fromDom$1
  };

  var get$2 = function (element) {
    return element.dom().innerHTML;
  };
  var set$1 = function (element, content) {
    var owner = $_4h5j2xy3jcq8hakl.owner(element);
    var docDom = owner.dom();
    var fragment = $_1t8d5wwtjcq8haao.fromDom(docDom.createDocumentFragment());
    var contentElements = $_9ek449ycjcq8halu.fromHtml(content, docDom);
    $_hk3r9y6jcq8hal3.append(fragment, contentElements);
    $_axfxsny5jcq8hal1.empty(element);
    $_1lvp6jy2jcq8hakj.append(element, fragment);
  };
  var getOuter = function (element) {
    var container = $_1t8d5wwtjcq8haao.fromTag('div');
    var clone = $_1t8d5wwtjcq8haao.fromDom(element.dom().cloneNode(true));
    $_1lvp6jy2jcq8hakj.append(container, clone);
    return get$2(container);
  };
  var $_69dru8ybjcq8hals = {
    get: get$2,
    set: set$1,
    getOuter: getOuter
  };

  var clone$1 = function (original, deep) {
    return $_1t8d5wwtjcq8haao.fromDom(original.dom().cloneNode(deep));
  };
  var shallow$1 = function (original) {
    return clone$1(original, false);
  };
  var deep$1 = function (original) {
    return clone$1(original, true);
  };
  var shallowAs = function (original, tag) {
    var nu = $_1t8d5wwtjcq8haao.fromTag(tag);
    var attributes = $_3kyqh4xwjcq8hajw.clone(original);
    $_3kyqh4xwjcq8hajw.setAll(nu, attributes);
    return nu;
  };
  var copy = function (original, tag) {
    var nu = shallowAs(original, tag);
    var cloneChildren = $_4h5j2xy3jcq8hakl.children(deep$1(original));
    $_hk3r9y6jcq8hal3.append(nu, cloneChildren);
    return nu;
  };
  var mutate = function (original, tag) {
    var nu = shallowAs(original, tag);
    $_1lvp6jy2jcq8hakj.before(original, nu);
    var children = $_4h5j2xy3jcq8hakl.children(original);
    $_hk3r9y6jcq8hal3.append(nu, children);
    $_axfxsny5jcq8hal1.remove(original);
    return nu;
  };
  var $_7nsnnlydjcq8halw = {
    shallow: shallow$1,
    shallowAs: shallowAs,
    deep: deep$1,
    copy: copy,
    mutate: mutate
  };

  var getHtml = function (element) {
    var clone = $_7nsnnlydjcq8halw.shallow(element);
    return $_69dru8ybjcq8hals.getOuter(clone);
  };
  var $_5l0oocyajcq8halp = { getHtml: getHtml };

  var element = function (elem) {
    return $_5l0oocyajcq8halp.getHtml(elem);
  };
  var $_2g4xv2y9jcq8hali = { element: element };

  var cat = function (arr) {
    var r = [];
    var push = function (x) {
      r.push(x);
    };
    for (var i = 0; i < arr.length; i++) {
      arr[i].each(push);
    }
    return r;
  };
  var findMap = function (arr, f) {
    for (var i = 0; i < arr.length; i++) {
      var r = f(arr[i], i);
      if (r.isSome()) {
        return r;
      }
    }
    return $_9m6n87wajcq8ha9e.none();
  };
  var liftN = function (arr, f) {
    var r = [];
    for (var i = 0; i < arr.length; i++) {
      var x = arr[i];
      if (x.isSome()) {
        r.push(x.getOrDie());
      } else {
        return $_9m6n87wajcq8ha9e.none();
      }
    }
    return $_9m6n87wajcq8ha9e.some(f.apply(null, r));
  };
  var $_4d7j4zyejcq8halz = {
    cat: cat,
    findMap: findMap,
    liftN: liftN
  };

  var unknown$3 = 'unknown';
  var debugging = true;
  var CHROME_INSPECTOR_GLOBAL = '__CHROME_INSPECTOR_CONNECTION_TO_ALLOY__';
  var eventsMonitored = [];
  var path$1 = [
    'alloy/data/Fields',
    'alloy/debugging/Debugging'
  ];
  var getTrace = function () {
    if (debugging === false)
      return unknown$3;
    var err = new Error();
    if (err.stack !== undefined) {
      var lines = err.stack.split('\n');
      return $_dojsh2w9jcq8ha93.find(lines, function (line) {
        return line.indexOf('alloy') > 0 && !$_dojsh2w9jcq8ha93.exists(path$1, function (p) {
          return line.indexOf(p) > -1;
        });
      }).getOr(unknown$3);
    } else {
      return unknown$3;
    }
  };
  var logHandler = function (label, handlerName, trace) {
  };
  var ignoreEvent = {
    logEventCut: $_dh3z58wbjcq8ha9h.noop,
    logEventStopped: $_dh3z58wbjcq8ha9h.noop,
    logNoParent: $_dh3z58wbjcq8ha9h.noop,
    logEventNoHandlers: $_dh3z58wbjcq8ha9h.noop,
    logEventResponse: $_dh3z58wbjcq8ha9h.noop,
    write: $_dh3z58wbjcq8ha9h.noop
  };
  var monitorEvent = function (eventName, initialTarget, f) {
    var logger = debugging && (eventsMonitored === '*' || $_dojsh2w9jcq8ha93.contains(eventsMonitored, eventName)) ? function () {
      var sequence = [];
      return {
        logEventCut: function (name, target, purpose) {
          sequence.push({
            outcome: 'cut',
            target: target,
            purpose: purpose
          });
        },
        logEventStopped: function (name, target, purpose) {
          sequence.push({
            outcome: 'stopped',
            target: target,
            purpose: purpose
          });
        },
        logNoParent: function (name, target, purpose) {
          sequence.push({
            outcome: 'no-parent',
            target: target,
            purpose: purpose
          });
        },
        logEventNoHandlers: function (name, target) {
          sequence.push({
            outcome: 'no-handlers-left',
            target: target
          });
        },
        logEventResponse: function (name, target, purpose) {
          sequence.push({
            outcome: 'response',
            purpose: purpose,
            target: target
          });
        },
        write: function () {
          if ($_dojsh2w9jcq8ha93.contains([
              'mousemove',
              'mouseover',
              'mouseout',
              $_51ilu1wwjcq8haax.systemInit()
            ], eventName))
            return;
          console.log(eventName, {
            event: eventName,
            target: initialTarget.dom(),
            sequence: $_dojsh2w9jcq8ha93.map(sequence, function (s) {
              if (!$_dojsh2w9jcq8ha93.contains([
                  'cut',
                  'stopped',
                  'response'
                ], s.outcome))
                return s.outcome;
              else
                return '{' + s.purpose + '} ' + s.outcome + ' at (' + $_2g4xv2y9jcq8hali.element(s.target) + ')';
            })
          });
        }
      };
    }() : ignoreEvent;
    var output = f(logger);
    logger.write();
    return output;
  };
  var inspectorInfo = function (comp) {
    var go = function (c) {
      var cSpec = c.spec();
      return {
        '(original.spec)': cSpec,
        '(dom.ref)': c.element().dom(),
        '(element)': $_2g4xv2y9jcq8hali.element(c.element()),
        '(initComponents)': $_dojsh2w9jcq8ha93.map(cSpec.components !== undefined ? cSpec.components : [], go),
        '(components)': $_dojsh2w9jcq8ha93.map(c.components(), go),
        '(bound.events)': $_et458cx0jcq8hab6.mapToArray(c.events(), function (v, k) {
          return [k];
        }).join(', '),
        '(behaviours)': cSpec.behaviours !== undefined ? $_et458cx0jcq8hab6.map(cSpec.behaviours, function (v, k) {
          return v === undefined ? '--revoked--' : {
            config: v.configAsRaw(),
            'original-config': v.initialConfig,
            state: c.readState(k)
          };
        }) : 'none'
      };
    };
    return go(comp);
  };
  var getOrInitConnection = function () {
    if (window[CHROME_INSPECTOR_GLOBAL] !== undefined)
      return window[CHROME_INSPECTOR_GLOBAL];
    else {
      window[CHROME_INSPECTOR_GLOBAL] = {
        systems: {},
        lookup: function (uid) {
          var systems = window[CHROME_INSPECTOR_GLOBAL].systems;
          var connections = $_et458cx0jcq8hab6.keys(systems);
          return $_4d7j4zyejcq8halz.findMap(connections, function (conn) {
            var connGui = systems[conn];
            return connGui.getByUid(uid).toOption().map(function (comp) {
              return $_f2tmkex6jcq8hach.wrap($_2g4xv2y9jcq8hali.element(comp.element()), inspectorInfo(comp));
            });
          });
        }
      };
      return window[CHROME_INSPECTOR_GLOBAL];
    }
  };
  var registerInspector = function (name, gui) {
    var connection = getOrInitConnection();
    connection.systems[name] = gui;
  };
  var $_dxnqasy8jcq8hal9 = {
    logHandler: logHandler,
    noLogger: $_dh3z58wbjcq8ha9h.constant(ignoreEvent),
    getTrace: getTrace,
    monitorEvent: monitorEvent,
    isDebugging: $_dh3z58wbjcq8ha9h.constant(debugging),
    registerInspector: registerInspector
  };

  var Cell = function (initial) {
    var value = initial;
    var get = function () {
      return value;
    };
    var set = function (v) {
      value = v;
    };
    var clone = function () {
      return Cell(get());
    };
    return {
      get: get,
      set: set,
      clone: clone
    };
  };

  var ClosestOrAncestor = function (is, ancestor, scope, a, isRoot) {
    return is(scope, a) ? $_9m6n87wajcq8ha9e.some(scope) : $_6xn7hbwzjcq8hab5.isFunction(isRoot) && isRoot(scope) ? $_9m6n87wajcq8ha9e.none() : ancestor(scope, a, isRoot);
  };

  var first$1 = function (predicate) {
    return descendant$1($_4axtmsy7jcq8hal6.body(), predicate);
  };
  var ancestor$1 = function (scope, predicate, isRoot) {
    var element = scope.dom();
    var stop = $_6xn7hbwzjcq8hab5.isFunction(isRoot) ? isRoot : $_dh3z58wbjcq8ha9h.constant(false);
    while (element.parentNode) {
      element = element.parentNode;
      var el = $_1t8d5wwtjcq8haao.fromDom(element);
      if (predicate(el))
        return $_9m6n87wajcq8ha9e.some(el);
      else if (stop(el))
        break;
    }
    return $_9m6n87wajcq8ha9e.none();
  };
  var closest$1 = function (scope, predicate, isRoot) {
    var is = function (scope) {
      return predicate(scope);
    };
    return ClosestOrAncestor(is, ancestor$1, scope, predicate, isRoot);
  };
  var sibling$1 = function (scope, predicate) {
    var element = scope.dom();
    if (!element.parentNode)
      return $_9m6n87wajcq8ha9e.none();
    return child$2($_1t8d5wwtjcq8haao.fromDom(element.parentNode), function (x) {
      return !$_darej4w8jcq8ha8v.eq(scope, x) && predicate(x);
    });
  };
  var child$2 = function (scope, predicate) {
    var result = $_dojsh2w9jcq8ha93.find(scope.dom().childNodes, $_dh3z58wbjcq8ha9h.compose(predicate, $_1t8d5wwtjcq8haao.fromDom));
    return result.map($_1t8d5wwtjcq8haao.fromDom);
  };
  var descendant$1 = function (scope, predicate) {
    var descend = function (element) {
      for (var i = 0; i < element.childNodes.length; i++) {
        if (predicate($_1t8d5wwtjcq8haao.fromDom(element.childNodes[i])))
          return $_9m6n87wajcq8ha9e.some($_1t8d5wwtjcq8haao.fromDom(element.childNodes[i]));
        var res = descend(element.childNodes[i]);
        if (res.isSome())
          return res;
      }
      return $_9m6n87wajcq8ha9e.none();
    };
    return descend(scope.dom());
  };
  var $_1vm5o1yijcq8ham7 = {
    first: first$1,
    ancestor: ancestor$1,
    closest: closest$1,
    sibling: sibling$1,
    child: child$2,
    descendant: descendant$1
  };

  var any$1 = function (predicate) {
    return $_1vm5o1yijcq8ham7.first(predicate).isSome();
  };
  var ancestor = function (scope, predicate, isRoot) {
    return $_1vm5o1yijcq8ham7.ancestor(scope, predicate, isRoot).isSome();
  };
  var closest = function (scope, predicate, isRoot) {
    return $_1vm5o1yijcq8ham7.closest(scope, predicate, isRoot).isSome();
  };
  var sibling = function (scope, predicate) {
    return $_1vm5o1yijcq8ham7.sibling(scope, predicate).isSome();
  };
  var child$1 = function (scope, predicate) {
    return $_1vm5o1yijcq8ham7.child(scope, predicate).isSome();
  };
  var descendant = function (scope, predicate) {
    return $_1vm5o1yijcq8ham7.descendant(scope, predicate).isSome();
  };
  var $_83gpyzyhjcq8ham5 = {
    any: any$1,
    ancestor: ancestor,
    closest: closest,
    sibling: sibling,
    child: child$1,
    descendant: descendant
  };

  var focus = function (element) {
    element.dom().focus();
  };
  var blur = function (element) {
    element.dom().blur();
  };
  var hasFocus = function (element) {
    var doc = $_4h5j2xy3jcq8hakl.owner(element).dom();
    return element.dom() === doc.activeElement;
  };
  var active = function (_doc) {
    var doc = _doc !== undefined ? _doc.dom() : document;
    return $_9m6n87wajcq8ha9e.from(doc.activeElement).map($_1t8d5wwtjcq8haao.fromDom);
  };
  var focusInside = function (element) {
    var doc = $_4h5j2xy3jcq8hakl.owner(element);
    var inside = active(doc).filter(function (a) {
      return $_83gpyzyhjcq8ham5.closest(a, $_dh3z58wbjcq8ha9h.curry($_darej4w8jcq8ha8v.eq, element));
    });
    inside.fold(function () {
      focus(element);
    }, $_dh3z58wbjcq8ha9h.noop);
  };
  var search = function (element) {
    return active($_4h5j2xy3jcq8hakl.owner(element)).filter(function (e) {
      return element.dom().contains(e.dom());
    });
  };
  var $_dgsby1ygjcq8ham1 = {
    hasFocus: hasFocus,
    focus: focus,
    blur: blur,
    active: active,
    search: search,
    focusInside: focusInside
  };

  var ThemeManager = tinymce.util.Tools.resolve('tinymce.ThemeManager');

  var DOMUtils = tinymce.util.Tools.resolve('tinymce.dom.DOMUtils');

  var openLink = function (target) {
    var link = document.createElement('a');
    link.target = '_blank';
    link.href = target.href;
    link.rel = 'noreferrer noopener';
    var nuEvt = document.createEvent('MouseEvents');
    nuEvt.initMouseEvent('click', true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
    document.body.appendChild(link);
    link.dispatchEvent(nuEvt);
    document.body.removeChild(link);
  };
  var $_cwvd7vymjcq8hamh = { openLink: openLink };

  var isSkinDisabled = function (editor) {
    return editor.settings.skin === false;
  };
  var $_6y1d3jynjcq8hami = { isSkinDisabled: isSkinDisabled };

  var formatChanged = 'formatChanged';
  var orientationChanged = 'orientationChanged';
  var dropupDismissed = 'dropupDismissed';
  var $_94pvbiyojcq8hamj = {
    formatChanged: $_dh3z58wbjcq8ha9h.constant(formatChanged),
    orientationChanged: $_dh3z58wbjcq8ha9h.constant(orientationChanged),
    dropupDismissed: $_dh3z58wbjcq8ha9h.constant(dropupDismissed)
  };

  var chooseChannels = function (channels, message) {
    return message.universal() ? channels : $_dojsh2w9jcq8ha93.filter(channels, function (ch) {
      return $_dojsh2w9jcq8ha93.contains(message.channels(), ch);
    });
  };
  var events = function (receiveConfig) {
    return $_dkbc99w6jcq8ha8p.derive([$_dkbc99w6jcq8ha8p.run($_51ilu1wwjcq8haax.receive(), function (component, message) {
        var channelMap = receiveConfig.channels();
        var channels = $_et458cx0jcq8hab6.keys(channelMap);
        var targetChannels = chooseChannels(channels, message);
        $_dojsh2w9jcq8ha93.each(targetChannels, function (ch) {
          var channelInfo = channelMap[ch]();
          var channelSchema = channelInfo.schema();
          var data = $_g540acxhjcq8hadd.asStructOrDie('channel[' + ch + '] data\nReceiver: ' + $_2g4xv2y9jcq8hali.element(component.element()), channelSchema, message.data());
          channelInfo.onReceive()(component, data);
        });
      })]);
  };
  var $_2ryz9uyrjcq8han2 = { events: events };

  var menuFields = [
    $_ah67nix2jcq8habi.strict('menu'),
    $_ah67nix2jcq8habi.strict('selectedMenu')
  ];
  var itemFields = [
    $_ah67nix2jcq8habi.strict('item'),
    $_ah67nix2jcq8habi.strict('selectedItem')
  ];
  var schema = $_g540acxhjcq8hadd.objOfOnly(itemFields.concat(menuFields));
  var itemSchema = $_g540acxhjcq8hadd.objOfOnly(itemFields);
  var $_cas72dyujcq8hank = {
    menuFields: $_dh3z58wbjcq8ha9h.constant(menuFields),
    itemFields: $_dh3z58wbjcq8ha9h.constant(itemFields),
    schema: $_dh3z58wbjcq8ha9h.constant(schema),
    itemSchema: $_dh3z58wbjcq8ha9h.constant(itemSchema)
  };

  var initSize = $_ah67nix2jcq8habi.strictObjOf('initSize', [
    $_ah67nix2jcq8habi.strict('numColumns'),
    $_ah67nix2jcq8habi.strict('numRows')
  ]);
  var itemMarkers = function () {
    return $_ah67nix2jcq8habi.strictOf('markers', $_cas72dyujcq8hank.itemSchema());
  };
  var menuMarkers = function () {
    return $_ah67nix2jcq8habi.strictOf('markers', $_cas72dyujcq8hank.schema());
  };
  var tieredMenuMarkers = function () {
    return $_ah67nix2jcq8habi.strictObjOf('markers', [$_ah67nix2jcq8habi.strict('backgroundMenu')].concat($_cas72dyujcq8hank.menuFields()).concat($_cas72dyujcq8hank.itemFields()));
  };
  var markers = function (required) {
    return $_ah67nix2jcq8habi.strictObjOf('markers', $_dojsh2w9jcq8ha93.map(required, $_ah67nix2jcq8habi.strict));
  };
  var onPresenceHandler = function (label, fieldName, presence) {
    var trace = $_dxnqasy8jcq8hal9.getTrace();
    return $_ah67nix2jcq8habi.field(fieldName, fieldName, presence, $_g540acxhjcq8hadd.valueOf(function (f) {
      return $_yvshix8jcq8hacp.value(function () {
        $_dxnqasy8jcq8hal9.logHandler(label, fieldName, trace);
        return f.apply(undefined, arguments);
      });
    }));
  };
  var onHandler = function (fieldName) {
    return onPresenceHandler('onHandler', fieldName, $_27p6pex3jcq8habw.defaulted($_dh3z58wbjcq8ha9h.noop));
  };
  var onKeyboardHandler = function (fieldName) {
    return onPresenceHandler('onKeyboardHandler', fieldName, $_27p6pex3jcq8habw.defaulted($_9m6n87wajcq8ha9e.none));
  };
  var onStrictHandler = function (fieldName) {
    return onPresenceHandler('onHandler', fieldName, $_27p6pex3jcq8habw.strict());
  };
  var onStrictKeyboardHandler = function (fieldName) {
    return onPresenceHandler('onKeyboardHandler', fieldName, $_27p6pex3jcq8habw.strict());
  };
  var output$1 = function (name, value) {
    return $_ah67nix2jcq8habi.state(name, $_dh3z58wbjcq8ha9h.constant(value));
  };
  var snapshot$1 = function (name) {
    return $_ah67nix2jcq8habi.state(name, $_dh3z58wbjcq8ha9h.identity);
  };
  var $_fvpuwdytjcq8hanb = {
    initSize: $_dh3z58wbjcq8ha9h.constant(initSize),
    itemMarkers: itemMarkers,
    menuMarkers: menuMarkers,
    tieredMenuMarkers: tieredMenuMarkers,
    markers: markers,
    onHandler: onHandler,
    onKeyboardHandler: onKeyboardHandler,
    onStrictHandler: onStrictHandler,
    onStrictKeyboardHandler: onStrictKeyboardHandler,
    output: output$1,
    snapshot: snapshot$1
  };

  var ReceivingSchema = [$_ah67nix2jcq8habi.strictOf('channels', $_g540acxhjcq8hadd.setOf($_yvshix8jcq8hacp.value, $_g540acxhjcq8hadd.objOfOnly([
      $_fvpuwdytjcq8hanb.onStrictHandler('onReceive'),
      $_ah67nix2jcq8habi.defaulted('schema', $_g540acxhjcq8hadd.anyValue())
    ])))];

  var Receiving = $_bfiithw4jcq8ha84.create({
    fields: ReceivingSchema,
    name: 'receiving',
    active: $_2ryz9uyrjcq8han2
  });

  var updateAriaState = function (component, toggleConfig) {
    var pressed = isOn(component, toggleConfig);
    var ariaInfo = toggleConfig.aria();
    ariaInfo.update()(component, ariaInfo, pressed);
  };
  var toggle$2 = function (component, toggleConfig, toggleState) {
    $_waygfxujcq8hajt.toggle(component.element(), toggleConfig.toggleClass());
    updateAriaState(component, toggleConfig);
  };
  var on = function (component, toggleConfig, toggleState) {
    $_waygfxujcq8hajt.add(component.element(), toggleConfig.toggleClass());
    updateAriaState(component, toggleConfig);
  };
  var off = function (component, toggleConfig, toggleState) {
    $_waygfxujcq8hajt.remove(component.element(), toggleConfig.toggleClass());
    updateAriaState(component, toggleConfig);
  };
  var isOn = function (component, toggleConfig) {
    return $_waygfxujcq8hajt.has(component.element(), toggleConfig.toggleClass());
  };
  var onLoad = function (component, toggleConfig, toggleState) {
    var api = toggleConfig.selected() ? on : off;
    api(component, toggleConfig, toggleState);
  };
  var $_3jj067yxjcq8hant = {
    onLoad: onLoad,
    toggle: toggle$2,
    isOn: isOn,
    on: on,
    off: off
  };

  var exhibit = function (base, toggleConfig, toggleState) {
    return $_720ux0xkjcq8haj2.nu({});
  };
  var events$1 = function (toggleConfig, toggleState) {
    var execute = $_1oalwmw5jcq8ha8c.executeEvent(toggleConfig, toggleState, $_3jj067yxjcq8hant.toggle);
    var load = $_1oalwmw5jcq8ha8c.loadEvent(toggleConfig, toggleState, $_3jj067yxjcq8hant.onLoad);
    return $_dkbc99w6jcq8ha8p.derive($_dojsh2w9jcq8ha93.flatten([
      toggleConfig.toggleOnExecute() ? [execute] : [],
      [load]
    ]));
  };
  var $_d58nh4ywjcq8hanq = {
    exhibit: exhibit,
    events: events$1
  };

  var updatePressed = function (component, ariaInfo, status) {
    $_3kyqh4xwjcq8hajw.set(component.element(), 'aria-pressed', status);
    if (ariaInfo.syncWithExpanded())
      updateExpanded(component, ariaInfo, status);
  };
  var updateSelected = function (component, ariaInfo, status) {
    $_3kyqh4xwjcq8hajw.set(component.element(), 'aria-selected', status);
  };
  var updateChecked = function (component, ariaInfo, status) {
    $_3kyqh4xwjcq8hajw.set(component.element(), 'aria-checked', status);
  };
  var updateExpanded = function (component, ariaInfo, status) {
    $_3kyqh4xwjcq8hajw.set(component.element(), 'aria-expanded', status);
  };
  var tagAttributes = {
    button: ['aria-pressed'],
    'input:checkbox': ['aria-checked']
  };
  var roleAttributes = {
    'button': ['aria-pressed'],
    'listbox': [
      'aria-pressed',
      'aria-expanded'
    ],
    'menuitemcheckbox': ['aria-checked']
  };
  var detectFromTag = function (component) {
    var elem = component.element();
    var rawTag = $_4z03v7xxjcq8hak1.name(elem);
    var suffix = rawTag === 'input' && $_3kyqh4xwjcq8hajw.has(elem, 'type') ? ':' + $_3kyqh4xwjcq8hajw.get(elem, 'type') : '';
    return $_f2tmkex6jcq8hach.readOptFrom(tagAttributes, rawTag + suffix);
  };
  var detectFromRole = function (component) {
    var elem = component.element();
    if (!$_3kyqh4xwjcq8hajw.has(elem, 'role'))
      return $_9m6n87wajcq8ha9e.none();
    else {
      var role = $_3kyqh4xwjcq8hajw.get(elem, 'role');
      return $_f2tmkex6jcq8hach.readOptFrom(roleAttributes, role);
    }
  };
  var updateAuto = function (component, ariaInfo, status) {
    var attributes = detectFromRole(component).orThunk(function () {
      return detectFromTag(component);
    }).getOr([]);
    $_dojsh2w9jcq8ha93.each(attributes, function (attr) {
      $_3kyqh4xwjcq8hajw.set(component.element(), attr, status);
    });
  };
  var $_2qkzwoyzjcq8hao0 = {
    updatePressed: updatePressed,
    updateSelected: updateSelected,
    updateChecked: updateChecked,
    updateExpanded: updateExpanded,
    updateAuto: updateAuto
  };

  var ToggleSchema = [
    $_ah67nix2jcq8habi.defaulted('selected', false),
    $_ah67nix2jcq8habi.strict('toggleClass'),
    $_ah67nix2jcq8habi.defaulted('toggleOnExecute', true),
    $_ah67nix2jcq8habi.defaultedOf('aria', { mode: 'none' }, $_g540acxhjcq8hadd.choose('mode', {
      'pressed': [
        $_ah67nix2jcq8habi.defaulted('syncWithExpanded', false),
        $_fvpuwdytjcq8hanb.output('update', $_2qkzwoyzjcq8hao0.updatePressed)
      ],
      'checked': [$_fvpuwdytjcq8hanb.output('update', $_2qkzwoyzjcq8hao0.updateChecked)],
      'expanded': [$_fvpuwdytjcq8hanb.output('update', $_2qkzwoyzjcq8hao0.updateExpanded)],
      'selected': [$_fvpuwdytjcq8hanb.output('update', $_2qkzwoyzjcq8hao0.updateSelected)],
      'none': [$_fvpuwdytjcq8hanb.output('update', $_dh3z58wbjcq8ha9h.noop)]
    }))
  ];

  var Toggling = $_bfiithw4jcq8ha84.create({
    fields: ToggleSchema,
    name: 'toggling',
    active: $_d58nh4ywjcq8hanq,
    apis: $_3jj067yxjcq8hant
  });

  var format = function (command, update) {
    return Receiving.config({
      channels: $_f2tmkex6jcq8hach.wrap($_94pvbiyojcq8hamj.formatChanged(), {
        onReceive: function (button, data) {
          if (data.command === command) {
            update(button, data.state);
          }
        }
      })
    });
  };
  var orientation = function (onReceive) {
    return Receiving.config({ channels: $_f2tmkex6jcq8hach.wrap($_94pvbiyojcq8hamj.orientationChanged(), { onReceive: onReceive }) });
  };
  var receive = function (channel, onReceive) {
    return {
      key: channel,
      value: { onReceive: onReceive }
    };
  };
  var $_dnir0tz0jcq8hao8 = {
    format: format,
    orientation: orientation,
    receive: receive
  };

  var prefix = 'tinymce-mobile';
  var resolve$1 = function (p) {
    return prefix + '-' + p;
  };
  var $_30duqlz1jcq8haoh = {
    resolve: resolve$1,
    prefix: $_dh3z58wbjcq8ha9h.constant(prefix)
  };

  var exhibit$1 = function (base, unselectConfig) {
    return $_720ux0xkjcq8haj2.nu({
      styles: {
        '-webkit-user-select': 'none',
        'user-select': 'none',
        '-ms-user-select': 'none',
        '-moz-user-select': '-moz-none'
      },
      attributes: { 'unselectable': 'on' }
    });
  };
  var events$2 = function (unselectConfig) {
    return $_dkbc99w6jcq8ha8p.derive([$_dkbc99w6jcq8ha8p.abort($_gcr2umwxjcq8hab1.selectstart(), $_dh3z58wbjcq8ha9h.constant(true))]);
  };
  var $_2s2q1oz4jcq8haop = {
    events: events$2,
    exhibit: exhibit$1
  };

  var Unselecting = $_bfiithw4jcq8ha84.create({
    fields: [],
    name: 'unselecting',
    active: $_2s2q1oz4jcq8haop
  });

  var focus$1 = function (component, focusConfig) {
    if (!focusConfig.ignore()) {
      $_dgsby1ygjcq8ham1.focus(component.element());
      focusConfig.onFocus()(component);
    }
  };
  var blur$1 = function (component, focusConfig) {
    if (!focusConfig.ignore()) {
      $_dgsby1ygjcq8ham1.blur(component.element());
    }
  };
  var isFocused = function (component) {
    return $_dgsby1ygjcq8ham1.hasFocus(component.element());
  };
  var $_fqrjv8z8jcq8haoz = {
    focus: focus$1,
    blur: blur$1,
    isFocused: isFocused
  };

  var exhibit$2 = function (base, focusConfig) {
    if (focusConfig.ignore())
      return $_720ux0xkjcq8haj2.nu({});
    else
      return $_720ux0xkjcq8haj2.nu({ attributes: { 'tabindex': '-1' } });
  };
  var events$3 = function (focusConfig) {
    return $_dkbc99w6jcq8ha8p.derive([$_dkbc99w6jcq8ha8p.run($_51ilu1wwjcq8haax.focus(), function (component, simulatedEvent) {
        $_fqrjv8z8jcq8haoz.focus(component, focusConfig);
        simulatedEvent.stop();
      })]);
  };
  var $_asn23sz7jcq8haoy = {
    exhibit: exhibit$2,
    events: events$3
  };

  var FocusSchema = [
    $_fvpuwdytjcq8hanb.onHandler('onFocus'),
    $_ah67nix2jcq8habi.defaulted('ignore', false)
  ];

  var Focusing = $_bfiithw4jcq8ha84.create({
    fields: FocusSchema,
    name: 'focusing',
    active: $_asn23sz7jcq8haoy,
    apis: $_fqrjv8z8jcq8haoz
  });

  var $_fg3xg6zejcq8hapq = {
    BACKSPACE: $_dh3z58wbjcq8ha9h.constant([8]),
    TAB: $_dh3z58wbjcq8ha9h.constant([9]),
    ENTER: $_dh3z58wbjcq8ha9h.constant([13]),
    SHIFT: $_dh3z58wbjcq8ha9h.constant([16]),
    CTRL: $_dh3z58wbjcq8ha9h.constant([17]),
    ALT: $_dh3z58wbjcq8ha9h.constant([18]),
    CAPSLOCK: $_dh3z58wbjcq8ha9h.constant([20]),
    ESCAPE: $_dh3z58wbjcq8ha9h.constant([27]),
    SPACE: $_dh3z58wbjcq8ha9h.constant([32]),
    PAGEUP: $_dh3z58wbjcq8ha9h.constant([33]),
    PAGEDOWN: $_dh3z58wbjcq8ha9h.constant([34]),
    END: $_dh3z58wbjcq8ha9h.constant([35]),
    HOME: $_dh3z58wbjcq8ha9h.constant([36]),
    LEFT: $_dh3z58wbjcq8ha9h.constant([37]),
    UP: $_dh3z58wbjcq8ha9h.constant([38]),
    RIGHT: $_dh3z58wbjcq8ha9h.constant([39]),
    DOWN: $_dh3z58wbjcq8ha9h.constant([40]),
    INSERT: $_dh3z58wbjcq8ha9h.constant([45]),
    DEL: $_dh3z58wbjcq8ha9h.constant([46]),
    META: $_dh3z58wbjcq8ha9h.constant([
      91,
      93,
      224
    ]),
    F10: $_dh3z58wbjcq8ha9h.constant([121])
  };

  var cycleBy = function (value, delta, min, max) {
    var r = value + delta;
    if (r > max)
      return min;
    else
      return r < min ? max : r;
  };
  var cap = function (value, min, max) {
    if (value <= min)
      return min;
    else
      return value >= max ? max : value;
  };
  var $_1j04hzjjcq8haqh = {
    cycleBy: cycleBy,
    cap: cap
  };

  var all$3 = function (predicate) {
    return descendants$1($_4axtmsy7jcq8hal6.body(), predicate);
  };
  var ancestors$1 = function (scope, predicate, isRoot) {
    return $_dojsh2w9jcq8ha93.filter($_4h5j2xy3jcq8hakl.parents(scope, isRoot), predicate);
  };
  var siblings$2 = function (scope, predicate) {
    return $_dojsh2w9jcq8ha93.filter($_4h5j2xy3jcq8hakl.siblings(scope), predicate);
  };
  var children$2 = function (scope, predicate) {
    return $_dojsh2w9jcq8ha93.filter($_4h5j2xy3jcq8hakl.children(scope), predicate);
  };
  var descendants$1 = function (scope, predicate) {
    var result = [];
    $_dojsh2w9jcq8ha93.each($_4h5j2xy3jcq8hakl.children(scope), function (x) {
      if (predicate(x)) {
        result = result.concat([x]);
      }
      result = result.concat(descendants$1(x, predicate));
    });
    return result;
  };
  var $_bkz6j3zljcq8haqk = {
    all: all$3,
    ancestors: ancestors$1,
    siblings: siblings$2,
    children: children$2,
    descendants: descendants$1
  };

  var all$2 = function (selector) {
    return $_eekfszwsjcq8haak.all(selector);
  };
  var ancestors = function (scope, selector, isRoot) {
    return $_bkz6j3zljcq8haqk.ancestors(scope, function (e) {
      return $_eekfszwsjcq8haak.is(e, selector);
    }, isRoot);
  };
  var siblings$1 = function (scope, selector) {
    return $_bkz6j3zljcq8haqk.siblings(scope, function (e) {
      return $_eekfszwsjcq8haak.is(e, selector);
    });
  };
  var children$1 = function (scope, selector) {
    return $_bkz6j3zljcq8haqk.children(scope, function (e) {
      return $_eekfszwsjcq8haak.is(e, selector);
    });
  };
  var descendants = function (scope, selector) {
    return $_eekfszwsjcq8haak.all(selector, scope);
  };
  var $_9rnqqqzkjcq8haqj = {
    all: all$2,
    ancestors: ancestors,
    siblings: siblings$1,
    children: children$1,
    descendants: descendants
  };

  var first$2 = function (selector) {
    return $_eekfszwsjcq8haak.one(selector);
  };
  var ancestor$2 = function (scope, selector, isRoot) {
    return $_1vm5o1yijcq8ham7.ancestor(scope, function (e) {
      return $_eekfszwsjcq8haak.is(e, selector);
    }, isRoot);
  };
  var sibling$2 = function (scope, selector) {
    return $_1vm5o1yijcq8ham7.sibling(scope, function (e) {
      return $_eekfszwsjcq8haak.is(e, selector);
    });
  };
  var child$3 = function (scope, selector) {
    return $_1vm5o1yijcq8ham7.child(scope, function (e) {
      return $_eekfszwsjcq8haak.is(e, selector);
    });
  };
  var descendant$2 = function (scope, selector) {
    return $_eekfszwsjcq8haak.one(selector, scope);
  };
  var closest$2 = function (scope, selector, isRoot) {
    return ClosestOrAncestor($_eekfszwsjcq8haak.is, ancestor$2, scope, selector, isRoot);
  };
  var $_9rnmwhzmjcq8haqn = {
    first: first$2,
    ancestor: ancestor$2,
    sibling: sibling$2,
    child: child$3,
    descendant: descendant$2,
    closest: closest$2
  };

  var dehighlightAll = function (component, hConfig, hState) {
    var highlighted = $_9rnqqqzkjcq8haqj.descendants(component.element(), '.' + hConfig.highlightClass());
    $_dojsh2w9jcq8ha93.each(highlighted, function (h) {
      $_waygfxujcq8hajt.remove(h, hConfig.highlightClass());
      component.getSystem().getByDom(h).each(function (target) {
        hConfig.onDehighlight()(component, target);
      });
    });
  };
  var dehighlight = function (component, hConfig, hState, target) {
    var wasHighlighted = isHighlighted(component, hConfig, hState, target);
    $_waygfxujcq8hajt.remove(target.element(), hConfig.highlightClass());
    if (wasHighlighted)
      hConfig.onDehighlight()(component, target);
  };
  var highlight = function (component, hConfig, hState, target) {
    var wasHighlighted = isHighlighted(component, hConfig, hState, target);
    dehighlightAll(component, hConfig, hState);
    $_waygfxujcq8hajt.add(target.element(), hConfig.highlightClass());
    if (!wasHighlighted)
      hConfig.onHighlight()(component, target);
  };
  var highlightFirst = function (component, hConfig, hState) {
    getFirst(component, hConfig, hState).each(function (firstComp) {
      highlight(component, hConfig, hState, firstComp);
    });
  };
  var highlightLast = function (component, hConfig, hState) {
    getLast(component, hConfig, hState).each(function (lastComp) {
      highlight(component, hConfig, hState, lastComp);
    });
  };
  var highlightAt = function (component, hConfig, hState, index) {
    getByIndex(component, hConfig, hState, index).fold(function (err) {
      throw new Error(err);
    }, function (firstComp) {
      highlight(component, hConfig, hState, firstComp);
    });
  };
  var highlightBy = function (component, hConfig, hState, predicate) {
    var items = $_9rnqqqzkjcq8haqj.descendants(component.element(), '.' + hConfig.itemClass());
    var itemComps = $_4d7j4zyejcq8halz.cat($_dojsh2w9jcq8ha93.map(items, function (i) {
      return component.getSystem().getByDom(i).toOption();
    }));
    var targetComp = $_dojsh2w9jcq8ha93.find(itemComps, predicate);
    targetComp.each(function (c) {
      highlight(component, hConfig, hState, c);
    });
  };
  var isHighlighted = function (component, hConfig, hState, queryTarget) {
    return $_waygfxujcq8hajt.has(queryTarget.element(), hConfig.highlightClass());
  };
  var getHighlighted = function (component, hConfig, hState) {
    return $_9rnmwhzmjcq8haqn.descendant(component.element(), '.' + hConfig.highlightClass()).bind(component.getSystem().getByDom);
  };
  var getByIndex = function (component, hConfig, hState, index) {
    var items = $_9rnqqqzkjcq8haqj.descendants(component.element(), '.' + hConfig.itemClass());
    return $_9m6n87wajcq8ha9e.from(items[index]).fold(function () {
      return $_yvshix8jcq8hacp.error('No element found with index ' + index);
    }, component.getSystem().getByDom);
  };
  var getFirst = function (component, hConfig, hState) {
    return $_9rnmwhzmjcq8haqn.descendant(component.element(), '.' + hConfig.itemClass()).bind(component.getSystem().getByDom);
  };
  var getLast = function (component, hConfig, hState) {
    var items = $_9rnqqqzkjcq8haqj.descendants(component.element(), '.' + hConfig.itemClass());
    var last = items.length > 0 ? $_9m6n87wajcq8ha9e.some(items[items.length - 1]) : $_9m6n87wajcq8ha9e.none();
    return last.bind(component.getSystem().getByDom);
  };
  var getDelta = function (component, hConfig, hState, delta) {
    var items = $_9rnqqqzkjcq8haqj.descendants(component.element(), '.' + hConfig.itemClass());
    var current = $_dojsh2w9jcq8ha93.findIndex(items, function (item) {
      return $_waygfxujcq8hajt.has(item, hConfig.highlightClass());
    });
    return current.bind(function (selected) {
      var dest = $_1j04hzjjcq8haqh.cycleBy(selected, delta, 0, items.length - 1);
      return component.getSystem().getByDom(items[dest]);
    });
  };
  var getPrevious = function (component, hConfig, hState) {
    return getDelta(component, hConfig, hState, -1);
  };
  var getNext = function (component, hConfig, hState) {
    return getDelta(component, hConfig, hState, +1);
  };
  var $_7g668rzijcq8haq1 = {
    dehighlightAll: dehighlightAll,
    dehighlight: dehighlight,
    highlight: highlight,
    highlightFirst: highlightFirst,
    highlightLast: highlightLast,
    highlightAt: highlightAt,
    highlightBy: highlightBy,
    isHighlighted: isHighlighted,
    getHighlighted: getHighlighted,
    getFirst: getFirst,
    getLast: getLast,
    getPrevious: getPrevious,
    getNext: getNext
  };

  var HighlightSchema = [
    $_ah67nix2jcq8habi.strict('highlightClass'),
    $_ah67nix2jcq8habi.strict('itemClass'),
    $_fvpuwdytjcq8hanb.onHandler('onHighlight'),
    $_fvpuwdytjcq8hanb.onHandler('onDehighlight')
  ];

  var Highlighting = $_bfiithw4jcq8ha84.create({
    fields: HighlightSchema,
    name: 'highlighting',
    apis: $_7g668rzijcq8haq1
  });

  var dom = function () {
    var get = function (component) {
      return $_dgsby1ygjcq8ham1.search(component.element());
    };
    var set = function (component, focusee) {
      component.getSystem().triggerFocus(focusee, component.element());
    };
    return {
      get: get,
      set: set
    };
  };
  var highlights = function () {
    var get = function (component) {
      return Highlighting.getHighlighted(component).map(function (item) {
        return item.element();
      });
    };
    var set = function (component, element) {
      component.getSystem().getByDom(element).fold($_dh3z58wbjcq8ha9h.noop, function (item) {
        Highlighting.highlight(component, item);
      });
    };
    return {
      get: get,
      set: set
    };
  };
  var $_d956zszgjcq8hapx = {
    dom: dom,
    highlights: highlights
  };

  var inSet = function (keys) {
    return function (event) {
      return $_dojsh2w9jcq8ha93.contains(keys, event.raw().which);
    };
  };
  var and = function (preds) {
    return function (event) {
      return $_dojsh2w9jcq8ha93.forall(preds, function (pred) {
        return pred(event);
      });
    };
  };
  var is$1 = function (key) {
    return function (event) {
      return event.raw().which === key;
    };
  };
  var isShift = function (event) {
    return event.raw().shiftKey === true;
  };
  var isControl = function (event) {
    return event.raw().ctrlKey === true;
  };
  var $_6nqi6lzpjcq8haqt = {
    inSet: inSet,
    and: and,
    is: is$1,
    isShift: isShift,
    isNotShift: $_dh3z58wbjcq8ha9h.not(isShift),
    isControl: isControl,
    isNotControl: $_dh3z58wbjcq8ha9h.not(isControl)
  };

  var basic = function (key, action) {
    return {
      matches: $_6nqi6lzpjcq8haqt.is(key),
      classification: action
    };
  };
  var rule = function (matches, action) {
    return {
      matches: matches,
      classification: action
    };
  };
  var choose$2 = function (transitions, event) {
    var transition = $_dojsh2w9jcq8ha93.find(transitions, function (t) {
      return t.matches(event);
    });
    return transition.map(function (t) {
      return t.classification;
    });
  };
  var $_2o909wzojcq8haqr = {
    basic: basic,
    rule: rule,
    choose: choose$2
  };

  var typical = function (infoSchema, stateInit, getRules, getEvents, getApis, optFocusIn) {
    var schema = function () {
      return infoSchema.concat([
        $_ah67nix2jcq8habi.defaulted('focusManager', $_d956zszgjcq8hapx.dom()),
        $_fvpuwdytjcq8hanb.output('handler', me),
        $_fvpuwdytjcq8hanb.output('state', stateInit)
      ]);
    };
    var processKey = function (component, simulatedEvent, keyingConfig, keyingState) {
      var rules = getRules(component, simulatedEvent, keyingConfig, keyingState);
      return $_2o909wzojcq8haqr.choose(rules, simulatedEvent.event()).bind(function (rule) {
        return rule(component, simulatedEvent, keyingConfig, keyingState);
      });
    };
    var toEvents = function (keyingConfig, keyingState) {
      var otherEvents = getEvents(keyingConfig, keyingState);
      var keyEvents = $_dkbc99w6jcq8ha8p.derive(optFocusIn.map(function (focusIn) {
        return $_dkbc99w6jcq8ha8p.run($_51ilu1wwjcq8haax.focus(), function (component, simulatedEvent) {
          focusIn(component, keyingConfig, keyingState, simulatedEvent);
          simulatedEvent.stop();
        });
      }).toArray().concat([$_dkbc99w6jcq8ha8p.run($_gcr2umwxjcq8hab1.keydown(), function (component, simulatedEvent) {
          processKey(component, simulatedEvent, keyingConfig, keyingState).each(function (_) {
            simulatedEvent.stop();
          });
        })]));
      return $_936c00wyjcq8hab3.deepMerge(otherEvents, keyEvents);
    };
    var me = {
      schema: schema,
      processKey: processKey,
      toEvents: toEvents,
      toApis: getApis
    };
    return me;
  };
  var $_49azetzfjcq8hapt = { typical: typical };

  var cyclePrev = function (values, index, predicate) {
    var before = $_dojsh2w9jcq8ha93.reverse(values.slice(0, index));
    var after = $_dojsh2w9jcq8ha93.reverse(values.slice(index + 1));
    return $_dojsh2w9jcq8ha93.find(before.concat(after), predicate);
  };
  var tryPrev = function (values, index, predicate) {
    var before = $_dojsh2w9jcq8ha93.reverse(values.slice(0, index));
    return $_dojsh2w9jcq8ha93.find(before, predicate);
  };
  var cycleNext = function (values, index, predicate) {
    var before = values.slice(0, index);
    var after = values.slice(index + 1);
    return $_dojsh2w9jcq8ha93.find(after.concat(before), predicate);
  };
  var tryNext = function (values, index, predicate) {
    var after = values.slice(index + 1);
    return $_dojsh2w9jcq8ha93.find(after, predicate);
  };
  var $_1cll2lzqjcq8haqx = {
    cyclePrev: cyclePrev,
    cycleNext: cycleNext,
    tryPrev: tryPrev,
    tryNext: tryNext
  };

  var isSupported = function (dom) {
    return dom.style !== undefined;
  };
  var $_d16a4hztjcq8hara = { isSupported: isSupported };

  var internalSet = function (dom, property, value) {
    if (!$_6xn7hbwzjcq8hab5.isString(value)) {
      console.error('Invalid call to CSS.set. Property ', property, ':: Value ', value, ':: Element ', dom);
      throw new Error('CSS value must be a string: ' + value);
    }
    if ($_d16a4hztjcq8hara.isSupported(dom))
      dom.style.setProperty(property, value);
  };
  var internalRemove = function (dom, property) {
    if ($_d16a4hztjcq8hara.isSupported(dom))
      dom.style.removeProperty(property);
  };
  var set$3 = function (element, property, value) {
    var dom = element.dom();
    internalSet(dom, property, value);
  };
  var setAll$1 = function (element, css) {
    var dom = element.dom();
    $_et458cx0jcq8hab6.each(css, function (v, k) {
      internalSet(dom, k, v);
    });
  };
  var setOptions = function (element, css) {
    var dom = element.dom();
    $_et458cx0jcq8hab6.each(css, function (v, k) {
      v.fold(function () {
        internalRemove(dom, k);
      }, function (value) {
        internalSet(dom, k, value);
      });
    });
  };
  var get$4 = function (element, property) {
    var dom = element.dom();
    var styles = window.getComputedStyle(dom);
    var r = styles.getPropertyValue(property);
    var v = r === '' && !$_4axtmsy7jcq8hal6.inBody(element) ? getUnsafeProperty(dom, property) : r;
    return v === null ? undefined : v;
  };
  var getUnsafeProperty = function (dom, property) {
    return $_d16a4hztjcq8hara.isSupported(dom) ? dom.style.getPropertyValue(property) : '';
  };
  var getRaw = function (element, property) {
    var dom = element.dom();
    var raw = getUnsafeProperty(dom, property);
    return $_9m6n87wajcq8ha9e.from(raw).filter(function (r) {
      return r.length > 0;
    });
  };
  var getAllRaw = function (element) {
    var css = {};
    var dom = element.dom();
    if ($_d16a4hztjcq8hara.isSupported(dom)) {
      for (var i = 0; i < dom.style.length; i++) {
        var ruleName = dom.style.item(i);
        css[ruleName] = dom.style[ruleName];
      }
    }
    return css;
  };
  var isValidValue = function (tag, property, value) {
    var element = $_1t8d5wwtjcq8haao.fromTag(tag);
    set$3(element, property, value);
    var style = getRaw(element, property);
    return style.isSome();
  };
  var remove$5 = function (element, property) {
    var dom = element.dom();
    internalRemove(dom, property);
    if ($_3kyqh4xwjcq8hajw.has(element, 'style') && $_1llmbzwpjcq8haag.trim($_3kyqh4xwjcq8hajw.get(element, 'style')) === '') {
      $_3kyqh4xwjcq8hajw.remove(element, 'style');
    }
  };
  var preserve = function (element, f) {
    var oldStyles = $_3kyqh4xwjcq8hajw.get(element, 'style');
    var result = f(element);
    var restore = oldStyles === undefined ? $_3kyqh4xwjcq8hajw.remove : $_3kyqh4xwjcq8hajw.set;
    restore(element, 'style', oldStyles);
    return result;
  };
  var copy$1 = function (source, target) {
    var sourceDom = source.dom();
    var targetDom = target.dom();
    if ($_d16a4hztjcq8hara.isSupported(sourceDom) && $_d16a4hztjcq8hara.isSupported(targetDom)) {
      targetDom.style.cssText = sourceDom.style.cssText;
    }
  };
  var reflow = function (e) {
    return e.dom().offsetWidth;
  };
  var transferOne$1 = function (source, destination, style) {
    getRaw(source, style).each(function (value) {
      if (getRaw(destination, style).isNone())
        set$3(destination, style, value);
    });
  };
  var transfer$1 = function (source, destination, styles) {
    if (!$_4z03v7xxjcq8hak1.isElement(source) || !$_4z03v7xxjcq8hak1.isElement(destination))
      return;
    $_dojsh2w9jcq8ha93.each(styles, function (style) {
      transferOne$1(source, destination, style);
    });
  };
  var $_bljwzsjcq8har2 = {
    copy: copy$1,
    set: set$3,
    preserve: preserve,
    setAll: setAll$1,
    setOptions: setOptions,
    remove: remove$5,
    get: get$4,
    getRaw: getRaw,
    getAllRaw: getAllRaw,
    isValidValue: isValidValue,
    reflow: reflow,
    transfer: transfer$1
  };

  var Dimension = function (name, getOffset) {
    var set = function (element, h) {
      if (!$_6xn7hbwzjcq8hab5.isNumber(h) && !h.match(/^[0-9]+$/))
        throw name + '.set accepts only positive integer values. Value was ' + h;
      var dom = element.dom();
      if ($_d16a4hztjcq8hara.isSupported(dom))
        dom.style[name] = h + 'px';
    };
    var get = function (element) {
      var r = getOffset(element);
      if (r <= 0 || r === null) {
        var css = $_bljwzsjcq8har2.get(element, name);
        return parseFloat(css) || 0;
      }
      return r;
    };
    var getOuter = get;
    var aggregate = function (element, properties) {
      return $_dojsh2w9jcq8ha93.foldl(properties, function (acc, property) {
        var val = $_bljwzsjcq8har2.get(element, property);
        var value = val === undefined ? 0 : parseInt(val, 10);
        return isNaN(value) ? acc : acc + value;
      }, 0);
    };
    var max = function (element, value, properties) {
      var cumulativeInclusions = aggregate(element, properties);
      var absoluteMax = value > cumulativeInclusions ? value - cumulativeInclusions : 0;
      return absoluteMax;
    };
    return {
      set: set,
      get: get,
      getOuter: getOuter,
      aggregate: aggregate,
      max: max
    };
  };

  var api = Dimension('height', function (element) {
    return $_4axtmsy7jcq8hal6.inBody(element) ? element.dom().getBoundingClientRect().height : element.dom().offsetHeight;
  });
  var set$2 = function (element, h) {
    api.set(element, h);
  };
  var get$3 = function (element) {
    return api.get(element);
  };
  var getOuter$1 = function (element) {
    return api.getOuter(element);
  };
  var setMax = function (element, value) {
    var inclusions = [
      'margin-top',
      'border-top-width',
      'padding-top',
      'padding-bottom',
      'border-bottom-width',
      'margin-bottom'
    ];
    var absMax = api.max(element, value, inclusions);
    $_bljwzsjcq8har2.set(element, 'max-height', absMax + 'px');
  };
  var $_8ibl57zrjcq8har0 = {
    set: set$2,
    get: get$3,
    getOuter: getOuter$1,
    setMax: setMax
  };

  var create$2 = function (cyclicField) {
    var schema = [
      $_ah67nix2jcq8habi.option('onEscape'),
      $_ah67nix2jcq8habi.option('onEnter'),
      $_ah67nix2jcq8habi.defaulted('selector', '[data-alloy-tabstop="true"]'),
      $_ah67nix2jcq8habi.defaulted('firstTabstop', 0),
      $_ah67nix2jcq8habi.defaulted('useTabstopAt', $_dh3z58wbjcq8ha9h.constant(true)),
      $_ah67nix2jcq8habi.option('visibilitySelector')
    ].concat([cyclicField]);
    var isVisible = function (tabbingConfig, element) {
      var target = tabbingConfig.visibilitySelector().bind(function (sel) {
        return $_9rnmwhzmjcq8haqn.closest(element, sel);
      }).getOr(element);
      return $_8ibl57zrjcq8har0.get(target) > 0;
    };
    var findInitial = function (component, tabbingConfig) {
      var tabstops = $_9rnqqqzkjcq8haqj.descendants(component.element(), tabbingConfig.selector());
      var visibles = $_dojsh2w9jcq8ha93.filter(tabstops, function (elem) {
        return isVisible(tabbingConfig, elem);
      });
      return $_9m6n87wajcq8ha9e.from(visibles[tabbingConfig.firstTabstop()]);
    };
    var findCurrent = function (component, tabbingConfig) {
      return tabbingConfig.focusManager().get(component).bind(function (elem) {
        return $_9rnmwhzmjcq8haqn.closest(elem, tabbingConfig.selector());
      });
    };
    var isTabstop = function (tabbingConfig, element) {
      return isVisible(tabbingConfig, element) && tabbingConfig.useTabstopAt()(element);
    };
    var focusIn = function (component, tabbingConfig, tabbingState) {
      findInitial(component, tabbingConfig).each(function (target) {
        tabbingConfig.focusManager().set(component, target);
      });
    };
    var goFromTabstop = function (component, tabstops, stopIndex, tabbingConfig, cycle) {
      return cycle(tabstops, stopIndex, function (elem) {
        return isTabstop(tabbingConfig, elem);
      }).fold(function () {
        return tabbingConfig.cyclic() ? $_9m6n87wajcq8ha9e.some(true) : $_9m6n87wajcq8ha9e.none();
      }, function (target) {
        tabbingConfig.focusManager().set(component, target);
        return $_9m6n87wajcq8ha9e.some(true);
      });
    };
    var go = function (component, simulatedEvent, tabbingConfig, cycle) {
      var tabstops = $_9rnqqqzkjcq8haqj.descendants(component.element(), tabbingConfig.selector());
      return findCurrent(component, tabbingConfig).bind(function (tabstop) {
        var optStopIndex = $_dojsh2w9jcq8ha93.findIndex(tabstops, $_dh3z58wbjcq8ha9h.curry($_darej4w8jcq8ha8v.eq, tabstop));
        return optStopIndex.bind(function (stopIndex) {
          return goFromTabstop(component, tabstops, stopIndex, tabbingConfig, cycle);
        });
      });
    };
    var goBackwards = function (component, simulatedEvent, tabbingConfig, tabbingState) {
      var navigate = tabbingConfig.cyclic() ? $_1cll2lzqjcq8haqx.cyclePrev : $_1cll2lzqjcq8haqx.tryPrev;
      return go(component, simulatedEvent, tabbingConfig, navigate);
    };
    var goForwards = function (component, simulatedEvent, tabbingConfig, tabbingState) {
      var navigate = tabbingConfig.cyclic() ? $_1cll2lzqjcq8haqx.cycleNext : $_1cll2lzqjcq8haqx.tryNext;
      return go(component, simulatedEvent, tabbingConfig, navigate);
    };
    var execute = function (component, simulatedEvent, tabbingConfig, tabbingState) {
      return tabbingConfig.onEnter().bind(function (f) {
        return f(component, simulatedEvent);
      });
    };
    var exit = function (component, simulatedEvent, tabbingConfig, tabbingState) {
      return tabbingConfig.onEscape().bind(function (f) {
        return f(component, simulatedEvent);
      });
    };
    var getRules = $_dh3z58wbjcq8ha9h.constant([
      $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.and([
        $_6nqi6lzpjcq8haqt.isShift,
        $_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.TAB())
      ]), goBackwards),
      $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.TAB()), goForwards),
      $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.ESCAPE()), exit),
      $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.and([
        $_6nqi6lzpjcq8haqt.isNotShift,
        $_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.ENTER())
      ]), execute)
    ]);
    var getEvents = $_dh3z58wbjcq8ha9h.constant({});
    var getApis = $_dh3z58wbjcq8ha9h.constant({});
    return $_49azetzfjcq8hapt.typical(schema, $_6dyjy2xqjcq8hajl.init, getRules, getEvents, getApis, $_9m6n87wajcq8ha9e.some(focusIn));
  };
  var $_3bgagjzdjcq8hapf = { create: create$2 };

  var AcyclicType = $_3bgagjzdjcq8hapf.create($_ah67nix2jcq8habi.state('cyclic', $_dh3z58wbjcq8ha9h.constant(false)));

  var CyclicType = $_3bgagjzdjcq8hapf.create($_ah67nix2jcq8habi.state('cyclic', $_dh3z58wbjcq8ha9h.constant(true)));

  var inside = function (target) {
    return $_4z03v7xxjcq8hak1.name(target) === 'input' && $_3kyqh4xwjcq8hajw.get(target, 'type') !== 'radio' || $_4z03v7xxjcq8hak1.name(target) === 'textarea';
  };
  var $_bttiggzxjcq8harn = { inside: inside };

  var doDefaultExecute = function (component, simulatedEvent, focused) {
    $_3yqf3awvjcq8haat.dispatch(component, focused, $_51ilu1wwjcq8haax.execute());
    return $_9m6n87wajcq8ha9e.some(true);
  };
  var defaultExecute = function (component, simulatedEvent, focused) {
    return $_bttiggzxjcq8harn.inside(focused) && $_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.SPACE())(simulatedEvent.event()) ? $_9m6n87wajcq8ha9e.none() : doDefaultExecute(component, simulatedEvent, focused);
  };
  var $_annqbyzyjcq8harr = { defaultExecute: defaultExecute };

  var schema$1 = [
    $_ah67nix2jcq8habi.defaulted('execute', $_annqbyzyjcq8harr.defaultExecute),
    $_ah67nix2jcq8habi.defaulted('useSpace', false),
    $_ah67nix2jcq8habi.defaulted('useEnter', true),
    $_ah67nix2jcq8habi.defaulted('useControlEnter', false),
    $_ah67nix2jcq8habi.defaulted('useDown', false)
  ];
  var execute = function (component, simulatedEvent, executeConfig, executeState) {
    return executeConfig.execute()(component, simulatedEvent, component.element());
  };
  var getRules = function (component, simulatedEvent, executeConfig, executeState) {
    var spaceExec = executeConfig.useSpace() && !$_bttiggzxjcq8harn.inside(component.element()) ? $_fg3xg6zejcq8hapq.SPACE() : [];
    var enterExec = executeConfig.useEnter() ? $_fg3xg6zejcq8hapq.ENTER() : [];
    var downExec = executeConfig.useDown() ? $_fg3xg6zejcq8hapq.DOWN() : [];
    var execKeys = spaceExec.concat(enterExec).concat(downExec);
    return [$_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet(execKeys), execute)].concat(executeConfig.useControlEnter() ? [$_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.and([
        $_6nqi6lzpjcq8haqt.isControl,
        $_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.ENTER())
      ]), execute)] : []);
  };
  var getEvents = $_dh3z58wbjcq8ha9h.constant({});
  var getApis = $_dh3z58wbjcq8ha9h.constant({});
  var ExecutionType = $_49azetzfjcq8hapt.typical(schema$1, $_6dyjy2xqjcq8hajl.init, getRules, getEvents, getApis, $_9m6n87wajcq8ha9e.none());

  var flatgrid = function (spec) {
    var dimensions = Cell($_9m6n87wajcq8ha9e.none());
    var setGridSize = function (numRows, numColumns) {
      dimensions.set($_9m6n87wajcq8ha9e.some({
        numRows: $_dh3z58wbjcq8ha9h.constant(numRows),
        numColumns: $_dh3z58wbjcq8ha9h.constant(numColumns)
      }));
    };
    var getNumRows = function () {
      return dimensions.get().map(function (d) {
        return d.numRows();
      });
    };
    var getNumColumns = function () {
      return dimensions.get().map(function (d) {
        return d.numColumns();
      });
    };
    return BehaviourState({
      readState: $_dh3z58wbjcq8ha9h.constant({}),
      setGridSize: setGridSize,
      getNumRows: getNumRows,
      getNumColumns: getNumColumns
    });
  };
  var init$1 = function (spec) {
    return spec.state()(spec);
  };
  var $_asbjpt100jcq8has6 = {
    flatgrid: flatgrid,
    init: init$1
  };

  var onDirection = function (isLtr, isRtl) {
    return function (element) {
      return getDirection(element) === 'rtl' ? isRtl : isLtr;
    };
  };
  var getDirection = function (element) {
    return $_bljwzsjcq8har2.get(element, 'direction') === 'rtl' ? 'rtl' : 'ltr';
  };
  var $_cssxee102jcq8hase = {
    onDirection: onDirection,
    getDirection: getDirection
  };

  var useH = function (movement) {
    return function (component, simulatedEvent, config, state) {
      var move = movement(component.element());
      return use(move, component, simulatedEvent, config, state);
    };
  };
  var west = function (moveLeft, moveRight) {
    var movement = $_cssxee102jcq8hase.onDirection(moveLeft, moveRight);
    return useH(movement);
  };
  var east = function (moveLeft, moveRight) {
    var movement = $_cssxee102jcq8hase.onDirection(moveRight, moveLeft);
    return useH(movement);
  };
  var useV = function (move) {
    return function (component, simulatedEvent, config, state) {
      return use(move, component, simulatedEvent, config, state);
    };
  };
  var use = function (move, component, simulatedEvent, config, state) {
    var outcome = config.focusManager().get(component).bind(function (focused) {
      return move(component.element(), focused, config, state);
    });
    return outcome.map(function (newFocus) {
      config.focusManager().set(component, newFocus);
      return true;
    });
  };
  var $_5z9vbi101jcq8hasb = {
    east: east,
    west: west,
    north: useV,
    south: useV,
    move: useV
  };

  var indexInfo = $_4e5yxhxmjcq8hajd.immutableBag([
    'index',
    'candidates'
  ], []);
  var locate = function (candidates, predicate) {
    return $_dojsh2w9jcq8ha93.findIndex(candidates, predicate).map(function (index) {
      return indexInfo({
        index: index,
        candidates: candidates
      });
    });
  };
  var $_g1jfyr104jcq8hasl = { locate: locate };

  var visibilityToggler = function (element, property, hiddenValue, visibleValue) {
    var initial = $_bljwzsjcq8har2.get(element, property);
    if (initial === undefined)
      initial = '';
    var value = initial === hiddenValue ? visibleValue : hiddenValue;
    var off = $_dh3z58wbjcq8ha9h.curry($_bljwzsjcq8har2.set, element, property, initial);
    var on = $_dh3z58wbjcq8ha9h.curry($_bljwzsjcq8har2.set, element, property, value);
    return Toggler(off, on, false);
  };
  var toggler$1 = function (element) {
    return visibilityToggler(element, 'visibility', 'hidden', 'visible');
  };
  var displayToggler = function (element, value) {
    return visibilityToggler(element, 'display', 'none', value);
  };
  var isHidden = function (dom) {
    return dom.offsetWidth <= 0 && dom.offsetHeight <= 0;
  };
  var isVisible = function (element) {
    var dom = element.dom();
    return !isHidden(dom);
  };
  var $_6v0uy9105jcq8hasp = {
    toggler: toggler$1,
    displayToggler: displayToggler,
    isVisible: isVisible
  };

  var locateVisible = function (container, current, selector) {
    var filter = $_6v0uy9105jcq8hasp.isVisible;
    return locateIn(container, current, selector, filter);
  };
  var locateIn = function (container, current, selector, filter) {
    var predicate = $_dh3z58wbjcq8ha9h.curry($_darej4w8jcq8ha8v.eq, current);
    var candidates = $_9rnqqqzkjcq8haqj.descendants(container, selector);
    var visible = $_dojsh2w9jcq8ha93.filter(candidates, $_6v0uy9105jcq8hasp.isVisible);
    return $_g1jfyr104jcq8hasl.locate(visible, predicate);
  };
  var findIndex$2 = function (elements, target) {
    return $_dojsh2w9jcq8ha93.findIndex(elements, function (elem) {
      return $_darej4w8jcq8ha8v.eq(target, elem);
    });
  };
  var $_9hdz1o103jcq8hasf = {
    locateVisible: locateVisible,
    locateIn: locateIn,
    findIndex: findIndex$2
  };

  var withGrid = function (values, index, numCols, f) {
    var oldRow = Math.floor(index / numCols);
    var oldColumn = index % numCols;
    return f(oldRow, oldColumn).bind(function (address) {
      var newIndex = address.row() * numCols + address.column();
      return newIndex >= 0 && newIndex < values.length ? $_9m6n87wajcq8ha9e.some(values[newIndex]) : $_9m6n87wajcq8ha9e.none();
    });
  };
  var cycleHorizontal = function (values, index, numRows, numCols, delta) {
    return withGrid(values, index, numCols, function (oldRow, oldColumn) {
      var onLastRow = oldRow === numRows - 1;
      var colsInRow = onLastRow ? values.length - oldRow * numCols : numCols;
      var newColumn = $_1j04hzjjcq8haqh.cycleBy(oldColumn, delta, 0, colsInRow - 1);
      return $_9m6n87wajcq8ha9e.some({
        row: $_dh3z58wbjcq8ha9h.constant(oldRow),
        column: $_dh3z58wbjcq8ha9h.constant(newColumn)
      });
    });
  };
  var cycleVertical = function (values, index, numRows, numCols, delta) {
    return withGrid(values, index, numCols, function (oldRow, oldColumn) {
      var newRow = $_1j04hzjjcq8haqh.cycleBy(oldRow, delta, 0, numRows - 1);
      var onLastRow = newRow === numRows - 1;
      var colsInRow = onLastRow ? values.length - newRow * numCols : numCols;
      var newCol = $_1j04hzjjcq8haqh.cap(oldColumn, 0, colsInRow - 1);
      return $_9m6n87wajcq8ha9e.some({
        row: $_dh3z58wbjcq8ha9h.constant(newRow),
        column: $_dh3z58wbjcq8ha9h.constant(newCol)
      });
    });
  };
  var cycleRight = function (values, index, numRows, numCols) {
    return cycleHorizontal(values, index, numRows, numCols, +1);
  };
  var cycleLeft = function (values, index, numRows, numCols) {
    return cycleHorizontal(values, index, numRows, numCols, -1);
  };
  var cycleUp = function (values, index, numRows, numCols) {
    return cycleVertical(values, index, numRows, numCols, -1);
  };
  var cycleDown = function (values, index, numRows, numCols) {
    return cycleVertical(values, index, numRows, numCols, +1);
  };
  var $_3u8gjz106jcq8hass = {
    cycleDown: cycleDown,
    cycleUp: cycleUp,
    cycleLeft: cycleLeft,
    cycleRight: cycleRight
  };

  var schema$2 = [
    $_ah67nix2jcq8habi.strict('selector'),
    $_ah67nix2jcq8habi.defaulted('execute', $_annqbyzyjcq8harr.defaultExecute),
    $_fvpuwdytjcq8hanb.onKeyboardHandler('onEscape'),
    $_ah67nix2jcq8habi.defaulted('captureTab', false),
    $_fvpuwdytjcq8hanb.initSize()
  ];
  var focusIn = function (component, gridConfig, gridState) {
    $_9rnmwhzmjcq8haqn.descendant(component.element(), gridConfig.selector()).each(function (first) {
      gridConfig.focusManager().set(component, first);
    });
  };
  var findCurrent = function (component, gridConfig) {
    return gridConfig.focusManager().get(component).bind(function (elem) {
      return $_9rnmwhzmjcq8haqn.closest(elem, gridConfig.selector());
    });
  };
  var execute$1 = function (component, simulatedEvent, gridConfig, gridState) {
    return findCurrent(component, gridConfig).bind(function (focused) {
      return gridConfig.execute()(component, simulatedEvent, focused);
    });
  };
  var doMove = function (cycle) {
    return function (element, focused, gridConfig, gridState) {
      return $_9hdz1o103jcq8hasf.locateVisible(element, focused, gridConfig.selector()).bind(function (identified) {
        return cycle(identified.candidates(), identified.index(), gridState.getNumRows().getOr(gridConfig.initSize().numRows()), gridState.getNumColumns().getOr(gridConfig.initSize().numColumns()));
      });
    };
  };
  var handleTab = function (component, simulatedEvent, gridConfig, gridState) {
    return gridConfig.captureTab() ? $_9m6n87wajcq8ha9e.some(true) : $_9m6n87wajcq8ha9e.none();
  };
  var doEscape = function (component, simulatedEvent, gridConfig, gridState) {
    return gridConfig.onEscape()(component, simulatedEvent);
  };
  var moveLeft = doMove($_3u8gjz106jcq8hass.cycleLeft);
  var moveRight = doMove($_3u8gjz106jcq8hass.cycleRight);
  var moveNorth = doMove($_3u8gjz106jcq8hass.cycleUp);
  var moveSouth = doMove($_3u8gjz106jcq8hass.cycleDown);
  var getRules$1 = $_dh3z58wbjcq8ha9h.constant([
    $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.LEFT()), $_5z9vbi101jcq8hasb.west(moveLeft, moveRight)),
    $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.RIGHT()), $_5z9vbi101jcq8hasb.east(moveLeft, moveRight)),
    $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.UP()), $_5z9vbi101jcq8hasb.north(moveNorth)),
    $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.DOWN()), $_5z9vbi101jcq8hasb.south(moveSouth)),
    $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.and([
      $_6nqi6lzpjcq8haqt.isShift,
      $_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.TAB())
    ]), handleTab),
    $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.and([
      $_6nqi6lzpjcq8haqt.isNotShift,
      $_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.TAB())
    ]), handleTab),
    $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.ESCAPE()), doEscape),
    $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.SPACE().concat($_fg3xg6zejcq8hapq.ENTER())), execute$1)
  ]);
  var getEvents$1 = $_dh3z58wbjcq8ha9h.constant({});
  var getApis$1 = {};
  var FlatgridType = $_49azetzfjcq8hapt.typical(schema$2, $_asbjpt100jcq8has6.flatgrid, getRules$1, getEvents$1, getApis$1, $_9m6n87wajcq8ha9e.some(focusIn));

  var horizontal = function (container, selector, current, delta) {
    return $_9hdz1o103jcq8hasf.locateVisible(container, current, selector, $_dh3z58wbjcq8ha9h.constant(true)).bind(function (identified) {
      var index = identified.index();
      var candidates = identified.candidates();
      var newIndex = $_1j04hzjjcq8haqh.cycleBy(index, delta, 0, candidates.length - 1);
      return $_9m6n87wajcq8ha9e.from(candidates[newIndex]);
    });
  };
  var $_2wim06108jcq8hat4 = { horizontal: horizontal };

  var schema$3 = [
    $_ah67nix2jcq8habi.strict('selector'),
    $_ah67nix2jcq8habi.defaulted('getInitial', $_9m6n87wajcq8ha9e.none),
    $_ah67nix2jcq8habi.defaulted('execute', $_annqbyzyjcq8harr.defaultExecute),
    $_ah67nix2jcq8habi.defaulted('executeOnMove', false)
  ];
  var findCurrent$1 = function (component, flowConfig) {
    return flowConfig.focusManager().get(component).bind(function (elem) {
      return $_9rnmwhzmjcq8haqn.closest(elem, flowConfig.selector());
    });
  };
  var execute$2 = function (component, simulatedEvent, flowConfig) {
    return findCurrent$1(component, flowConfig).bind(function (focused) {
      return flowConfig.execute()(component, simulatedEvent, focused);
    });
  };
  var focusIn$1 = function (component, flowConfig) {
    flowConfig.getInitial()(component).or($_9rnmwhzmjcq8haqn.descendant(component.element(), flowConfig.selector())).each(function (first) {
      flowConfig.focusManager().set(component, first);
    });
  };
  var moveLeft$1 = function (element, focused, info) {
    return $_2wim06108jcq8hat4.horizontal(element, info.selector(), focused, -1);
  };
  var moveRight$1 = function (element, focused, info) {
    return $_2wim06108jcq8hat4.horizontal(element, info.selector(), focused, +1);
  };
  var doMove$1 = function (movement) {
    return function (component, simulatedEvent, flowConfig) {
      return movement(component, simulatedEvent, flowConfig).bind(function () {
        return flowConfig.executeOnMove() ? execute$2(component, simulatedEvent, flowConfig) : $_9m6n87wajcq8ha9e.some(true);
      });
    };
  };
  var getRules$2 = function (_) {
    return [
      $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.LEFT().concat($_fg3xg6zejcq8hapq.UP())), doMove$1($_5z9vbi101jcq8hasb.west(moveLeft$1, moveRight$1))),
      $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.RIGHT().concat($_fg3xg6zejcq8hapq.DOWN())), doMove$1($_5z9vbi101jcq8hasb.east(moveLeft$1, moveRight$1))),
      $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.ENTER()), execute$2),
      $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.SPACE()), execute$2)
    ];
  };
  var getEvents$2 = $_dh3z58wbjcq8ha9h.constant({});
  var getApis$2 = $_dh3z58wbjcq8ha9h.constant({});
  var FlowType = $_49azetzfjcq8hapt.typical(schema$3, $_6dyjy2xqjcq8hajl.init, getRules$2, getEvents$2, getApis$2, $_9m6n87wajcq8ha9e.some(focusIn$1));

  var outcome = $_4e5yxhxmjcq8hajd.immutableBag([
    'rowIndex',
    'columnIndex',
    'cell'
  ], []);
  var toCell = function (matrix, rowIndex, columnIndex) {
    return $_9m6n87wajcq8ha9e.from(matrix[rowIndex]).bind(function (row) {
      return $_9m6n87wajcq8ha9e.from(row[columnIndex]).map(function (cell) {
        return outcome({
          rowIndex: rowIndex,
          columnIndex: columnIndex,
          cell: cell
        });
      });
    });
  };
  var cycleHorizontal$1 = function (matrix, rowIndex, startCol, deltaCol) {
    var row = matrix[rowIndex];
    var colsInRow = row.length;
    var newColIndex = $_1j04hzjjcq8haqh.cycleBy(startCol, deltaCol, 0, colsInRow - 1);
    return toCell(matrix, rowIndex, newColIndex);
  };
  var cycleVertical$1 = function (matrix, colIndex, startRow, deltaRow) {
    var nextRowIndex = $_1j04hzjjcq8haqh.cycleBy(startRow, deltaRow, 0, matrix.length - 1);
    var colsInNextRow = matrix[nextRowIndex].length;
    var nextColIndex = $_1j04hzjjcq8haqh.cap(colIndex, 0, colsInNextRow - 1);
    return toCell(matrix, nextRowIndex, nextColIndex);
  };
  var moveHorizontal = function (matrix, rowIndex, startCol, deltaCol) {
    var row = matrix[rowIndex];
    var colsInRow = row.length;
    var newColIndex = $_1j04hzjjcq8haqh.cap(startCol + deltaCol, 0, colsInRow - 1);
    return toCell(matrix, rowIndex, newColIndex);
  };
  var moveVertical = function (matrix, colIndex, startRow, deltaRow) {
    var nextRowIndex = $_1j04hzjjcq8haqh.cap(startRow + deltaRow, 0, matrix.length - 1);
    var colsInNextRow = matrix[nextRowIndex].length;
    var nextColIndex = $_1j04hzjjcq8haqh.cap(colIndex, 0, colsInNextRow - 1);
    return toCell(matrix, nextRowIndex, nextColIndex);
  };
  var cycleRight$1 = function (matrix, startRow, startCol) {
    return cycleHorizontal$1(matrix, startRow, startCol, +1);
  };
  var cycleLeft$1 = function (matrix, startRow, startCol) {
    return cycleHorizontal$1(matrix, startRow, startCol, -1);
  };
  var cycleUp$1 = function (matrix, startRow, startCol) {
    return cycleVertical$1(matrix, startCol, startRow, -1);
  };
  var cycleDown$1 = function (matrix, startRow, startCol) {
    return cycleVertical$1(matrix, startCol, startRow, +1);
  };
  var moveLeft$3 = function (matrix, startRow, startCol) {
    return moveHorizontal(matrix, startRow, startCol, -1);
  };
  var moveRight$3 = function (matrix, startRow, startCol) {
    return moveHorizontal(matrix, startRow, startCol, +1);
  };
  var moveUp = function (matrix, startRow, startCol) {
    return moveVertical(matrix, startCol, startRow, -1);
  };
  var moveDown = function (matrix, startRow, startCol) {
    return moveVertical(matrix, startCol, startRow, +1);
  };
  var $_g3smuv10ajcq8hatj = {
    cycleRight: cycleRight$1,
    cycleLeft: cycleLeft$1,
    cycleUp: cycleUp$1,
    cycleDown: cycleDown$1,
    moveLeft: moveLeft$3,
    moveRight: moveRight$3,
    moveUp: moveUp,
    moveDown: moveDown
  };

  var schema$4 = [
    $_ah67nix2jcq8habi.strictObjOf('selectors', [
      $_ah67nix2jcq8habi.strict('row'),
      $_ah67nix2jcq8habi.strict('cell')
    ]),
    $_ah67nix2jcq8habi.defaulted('cycles', true),
    $_ah67nix2jcq8habi.defaulted('previousSelector', $_9m6n87wajcq8ha9e.none),
    $_ah67nix2jcq8habi.defaulted('execute', $_annqbyzyjcq8harr.defaultExecute)
  ];
  var focusIn$2 = function (component, matrixConfig) {
    var focused = matrixConfig.previousSelector()(component).orThunk(function () {
      var selectors = matrixConfig.selectors();
      return $_9rnmwhzmjcq8haqn.descendant(component.element(), selectors.cell());
    });
    focused.each(function (cell) {
      matrixConfig.focusManager().set(component, cell);
    });
  };
  var execute$3 = function (component, simulatedEvent, matrixConfig) {
    return $_dgsby1ygjcq8ham1.search(component.element()).bind(function (focused) {
      return matrixConfig.execute()(component, simulatedEvent, focused);
    });
  };
  var toMatrix = function (rows, matrixConfig) {
    return $_dojsh2w9jcq8ha93.map(rows, function (row) {
      return $_9rnqqqzkjcq8haqj.descendants(row, matrixConfig.selectors().cell());
    });
  };
  var doMove$2 = function (ifCycle, ifMove) {
    return function (element, focused, matrixConfig) {
      var move = matrixConfig.cycles() ? ifCycle : ifMove;
      return $_9rnmwhzmjcq8haqn.closest(focused, matrixConfig.selectors().row()).bind(function (inRow) {
        var cellsInRow = $_9rnqqqzkjcq8haqj.descendants(inRow, matrixConfig.selectors().cell());
        return $_9hdz1o103jcq8hasf.findIndex(cellsInRow, focused).bind(function (colIndex) {
          var allRows = $_9rnqqqzkjcq8haqj.descendants(element, matrixConfig.selectors().row());
          return $_9hdz1o103jcq8hasf.findIndex(allRows, inRow).bind(function (rowIndex) {
            var matrix = toMatrix(allRows, matrixConfig);
            return move(matrix, rowIndex, colIndex).map(function (next) {
              return next.cell();
            });
          });
        });
      });
    };
  };
  var moveLeft$2 = doMove$2($_g3smuv10ajcq8hatj.cycleLeft, $_g3smuv10ajcq8hatj.moveLeft);
  var moveRight$2 = doMove$2($_g3smuv10ajcq8hatj.cycleRight, $_g3smuv10ajcq8hatj.moveRight);
  var moveNorth$1 = doMove$2($_g3smuv10ajcq8hatj.cycleUp, $_g3smuv10ajcq8hatj.moveUp);
  var moveSouth$1 = doMove$2($_g3smuv10ajcq8hatj.cycleDown, $_g3smuv10ajcq8hatj.moveDown);
  var getRules$3 = $_dh3z58wbjcq8ha9h.constant([
    $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.LEFT()), $_5z9vbi101jcq8hasb.west(moveLeft$2, moveRight$2)),
    $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.RIGHT()), $_5z9vbi101jcq8hasb.east(moveLeft$2, moveRight$2)),
    $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.UP()), $_5z9vbi101jcq8hasb.north(moveNorth$1)),
    $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.DOWN()), $_5z9vbi101jcq8hasb.south(moveSouth$1)),
    $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.SPACE().concat($_fg3xg6zejcq8hapq.ENTER())), execute$3)
  ]);
  var getEvents$3 = $_dh3z58wbjcq8ha9h.constant({});
  var getApis$3 = $_dh3z58wbjcq8ha9h.constant({});
  var MatrixType = $_49azetzfjcq8hapt.typical(schema$4, $_6dyjy2xqjcq8hajl.init, getRules$3, getEvents$3, getApis$3, $_9m6n87wajcq8ha9e.some(focusIn$2));

  var schema$5 = [
    $_ah67nix2jcq8habi.strict('selector'),
    $_ah67nix2jcq8habi.defaulted('execute', $_annqbyzyjcq8harr.defaultExecute),
    $_ah67nix2jcq8habi.defaulted('moveOnTab', false)
  ];
  var execute$4 = function (component, simulatedEvent, menuConfig) {
    return menuConfig.focusManager().get(component).bind(function (focused) {
      return menuConfig.execute()(component, simulatedEvent, focused);
    });
  };
  var focusIn$3 = function (component, menuConfig, simulatedEvent) {
    $_9rnmwhzmjcq8haqn.descendant(component.element(), menuConfig.selector()).each(function (first) {
      menuConfig.focusManager().set(component, first);
    });
  };
  var moveUp$1 = function (element, focused, info) {
    return $_2wim06108jcq8hat4.horizontal(element, info.selector(), focused, -1);
  };
  var moveDown$1 = function (element, focused, info) {
    return $_2wim06108jcq8hat4.horizontal(element, info.selector(), focused, +1);
  };
  var fireShiftTab = function (component, simulatedEvent, menuConfig) {
    return menuConfig.moveOnTab() ? $_5z9vbi101jcq8hasb.move(moveUp$1)(component, simulatedEvent, menuConfig) : $_9m6n87wajcq8ha9e.none();
  };
  var fireTab = function (component, simulatedEvent, menuConfig) {
    return menuConfig.moveOnTab() ? $_5z9vbi101jcq8hasb.move(moveDown$1)(component, simulatedEvent, menuConfig) : $_9m6n87wajcq8ha9e.none();
  };
  var getRules$4 = $_dh3z58wbjcq8ha9h.constant([
    $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.UP()), $_5z9vbi101jcq8hasb.move(moveUp$1)),
    $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.DOWN()), $_5z9vbi101jcq8hasb.move(moveDown$1)),
    $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.and([
      $_6nqi6lzpjcq8haqt.isShift,
      $_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.TAB())
    ]), fireShiftTab),
    $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.and([
      $_6nqi6lzpjcq8haqt.isNotShift,
      $_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.TAB())
    ]), fireTab),
    $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.ENTER()), execute$4),
    $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.SPACE()), execute$4)
  ]);
  var getEvents$4 = $_dh3z58wbjcq8ha9h.constant({});
  var getApis$4 = $_dh3z58wbjcq8ha9h.constant({});
  var MenuType = $_49azetzfjcq8hapt.typical(schema$5, $_6dyjy2xqjcq8hajl.init, getRules$4, getEvents$4, getApis$4, $_9m6n87wajcq8ha9e.some(focusIn$3));

  var schema$6 = [
    $_fvpuwdytjcq8hanb.onKeyboardHandler('onSpace'),
    $_fvpuwdytjcq8hanb.onKeyboardHandler('onEnter'),
    $_fvpuwdytjcq8hanb.onKeyboardHandler('onShiftEnter'),
    $_fvpuwdytjcq8hanb.onKeyboardHandler('onLeft'),
    $_fvpuwdytjcq8hanb.onKeyboardHandler('onRight'),
    $_fvpuwdytjcq8hanb.onKeyboardHandler('onTab'),
    $_fvpuwdytjcq8hanb.onKeyboardHandler('onShiftTab'),
    $_fvpuwdytjcq8hanb.onKeyboardHandler('onUp'),
    $_fvpuwdytjcq8hanb.onKeyboardHandler('onDown'),
    $_fvpuwdytjcq8hanb.onKeyboardHandler('onEscape'),
    $_ah67nix2jcq8habi.option('focusIn')
  ];
  var getRules$5 = function (component, simulatedEvent, executeInfo) {
    return [
      $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.SPACE()), executeInfo.onSpace()),
      $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.and([
        $_6nqi6lzpjcq8haqt.isNotShift,
        $_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.ENTER())
      ]), executeInfo.onEnter()),
      $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.and([
        $_6nqi6lzpjcq8haqt.isShift,
        $_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.ENTER())
      ]), executeInfo.onShiftEnter()),
      $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.and([
        $_6nqi6lzpjcq8haqt.isShift,
        $_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.TAB())
      ]), executeInfo.onShiftTab()),
      $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.and([
        $_6nqi6lzpjcq8haqt.isNotShift,
        $_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.TAB())
      ]), executeInfo.onTab()),
      $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.UP()), executeInfo.onUp()),
      $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.DOWN()), executeInfo.onDown()),
      $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.LEFT()), executeInfo.onLeft()),
      $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.RIGHT()), executeInfo.onRight()),
      $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.SPACE()), executeInfo.onSpace()),
      $_2o909wzojcq8haqr.rule($_6nqi6lzpjcq8haqt.inSet($_fg3xg6zejcq8hapq.ESCAPE()), executeInfo.onEscape())
    ];
  };
  var focusIn$4 = function (component, executeInfo) {
    return executeInfo.focusIn().bind(function (f) {
      return f(component, executeInfo);
    });
  };
  var getEvents$5 = $_dh3z58wbjcq8ha9h.constant({});
  var getApis$5 = $_dh3z58wbjcq8ha9h.constant({});
  var SpecialType = $_49azetzfjcq8hapt.typical(schema$6, $_6dyjy2xqjcq8hajl.init, getRules$5, getEvents$5, getApis$5, $_9m6n87wajcq8ha9e.some(focusIn$4));

  var $_ewanbezbjcq8hap6 = {
    acyclic: AcyclicType.schema(),
    cyclic: CyclicType.schema(),
    flow: FlowType.schema(),
    flatgrid: FlatgridType.schema(),
    matrix: MatrixType.schema(),
    execution: ExecutionType.schema(),
    menu: MenuType.schema(),
    special: SpecialType.schema()
  };

  var Keying = $_bfiithw4jcq8ha84.createModes({
    branchKey: 'mode',
    branches: $_ewanbezbjcq8hap6,
    name: 'keying',
    active: {
      events: function (keyingConfig, keyingState) {
        var handler = keyingConfig.handler();
        return handler.toEvents(keyingConfig, keyingState);
      }
    },
    apis: {
      focusIn: function (component) {
        component.getSystem().triggerFocus(component.element(), component.element());
      },
      setGridSize: function (component, keyConfig, keyState, numRows, numColumns) {
        if (!$_f2tmkex6jcq8hach.hasKey(keyState, 'setGridSize')) {
          console.error('Layout does not support setGridSize');
        } else {
          keyState.setGridSize(numRows, numColumns);
        }
      }
    },
    state: $_asbjpt100jcq8has6
  });

  var field$1 = function (name, forbidden) {
    return $_ah67nix2jcq8habi.defaultedObjOf(name, {}, $_dojsh2w9jcq8ha93.map(forbidden, function (f) {
      return $_ah67nix2jcq8habi.forbid(f.name(), 'Cannot configure ' + f.name() + ' for ' + name);
    }).concat([$_ah67nix2jcq8habi.state('dump', $_dh3z58wbjcq8ha9h.identity)]));
  };
  var get$5 = function (data) {
    return data.dump();
  };
  var $_b4pjyg10djcq8hau7 = {
    field: field$1,
    get: get$5
  };

  var unique = 0;
  var generate$1 = function (prefix) {
    var date = new Date();
    var time = date.getTime();
    var random = Math.floor(Math.random() * 1000000000);
    unique++;
    return prefix + '_' + random + unique + String(time);
  };
  var $_8zlm8d10gjcq8hauo = { generate: generate$1 };

  var premadeTag = $_8zlm8d10gjcq8hauo.generate('alloy-premade');
  var apiConfig = $_8zlm8d10gjcq8hauo.generate('api');
  var premade = function (comp) {
    return $_f2tmkex6jcq8hach.wrap(premadeTag, comp);
  };
  var getPremade = function (spec) {
    return $_f2tmkex6jcq8hach.readOptFrom(spec, premadeTag);
  };
  var makeApi = function (f) {
    return $_2ufx5exjjcq8haiz.markAsSketchApi(function (component) {
      var args = Array.prototype.slice.call(arguments, 0);
      var spi = component.config(apiConfig);
      return f.apply(undefined, [spi].concat(args));
    }, f);
  };
  var $_edxw3210fjcq8hauj = {
    apiConfig: $_dh3z58wbjcq8ha9h.constant(apiConfig),
    makeApi: makeApi,
    premade: premade,
    getPremade: getPremade
  };

  var adt$2 = $_dho4a6x4jcq8habz.generate([
    { required: ['data'] },
    { external: ['data'] },
    { optional: ['data'] },
    { group: ['data'] }
  ]);
  var fFactory = $_ah67nix2jcq8habi.defaulted('factory', { sketch: $_dh3z58wbjcq8ha9h.identity });
  var fSchema = $_ah67nix2jcq8habi.defaulted('schema', []);
  var fName = $_ah67nix2jcq8habi.strict('name');
  var fPname = $_ah67nix2jcq8habi.field('pname', 'pname', $_27p6pex3jcq8habw.defaultedThunk(function (typeSpec) {
    return '<alloy.' + $_8zlm8d10gjcq8hauo.generate(typeSpec.name) + '>';
  }), $_g540acxhjcq8hadd.anyValue());
  var fDefaults = $_ah67nix2jcq8habi.defaulted('defaults', $_dh3z58wbjcq8ha9h.constant({}));
  var fOverrides = $_ah67nix2jcq8habi.defaulted('overrides', $_dh3z58wbjcq8ha9h.constant({}));
  var requiredSpec = $_g540acxhjcq8hadd.objOf([
    fFactory,
    fSchema,
    fName,
    fPname,
    fDefaults,
    fOverrides
  ]);
  var externalSpec = $_g540acxhjcq8hadd.objOf([
    fFactory,
    fSchema,
    fName,
    fDefaults,
    fOverrides
  ]);
  var optionalSpec = $_g540acxhjcq8hadd.objOf([
    fFactory,
    fSchema,
    fName,
    fPname,
    fDefaults,
    fOverrides
  ]);
  var groupSpec = $_g540acxhjcq8hadd.objOf([
    fFactory,
    fSchema,
    fName,
    $_ah67nix2jcq8habi.strict('unit'),
    fPname,
    fDefaults,
    fOverrides
  ]);
  var asNamedPart = function (part) {
    return part.fold($_9m6n87wajcq8ha9e.some, $_9m6n87wajcq8ha9e.none, $_9m6n87wajcq8ha9e.some, $_9m6n87wajcq8ha9e.some);
  };
  var name$1 = function (part) {
    var get = function (data) {
      return data.name();
    };
    return part.fold(get, get, get, get);
  };
  var asCommon = function (part) {
    return part.fold($_dh3z58wbjcq8ha9h.identity, $_dh3z58wbjcq8ha9h.identity, $_dh3z58wbjcq8ha9h.identity, $_dh3z58wbjcq8ha9h.identity);
  };
  var convert = function (adtConstructor, partSpec) {
    return function (spec) {
      var data = $_g540acxhjcq8hadd.asStructOrDie('Converting part type', partSpec, spec);
      return adtConstructor(data);
    };
  };
  var $_50i5hr10kjcq8havc = {
    required: convert(adt$2.required, requiredSpec),
    external: convert(adt$2.external, externalSpec),
    optional: convert(adt$2.optional, optionalSpec),
    group: convert(adt$2.group, groupSpec),
    asNamedPart: asNamedPart,
    name: name$1,
    asCommon: asCommon,
    original: $_dh3z58wbjcq8ha9h.constant('entirety')
  };

  var placeholder = 'placeholder';
  var adt$3 = $_dho4a6x4jcq8habz.generate([
    {
      single: [
        'required',
        'valueThunk'
      ]
    },
    {
      multiple: [
        'required',
        'valueThunks'
      ]
    }
  ]);
  var isSubstitute = function (uiType) {
    return $_dojsh2w9jcq8ha93.contains([placeholder], uiType);
  };
  var subPlaceholder = function (owner, detail, compSpec, placeholders) {
    if (owner.exists(function (o) {
        return o !== compSpec.owner;
      }))
      return adt$3.single(true, $_dh3z58wbjcq8ha9h.constant(compSpec));
    return $_f2tmkex6jcq8hach.readOptFrom(placeholders, compSpec.name).fold(function () {
      throw new Error('Unknown placeholder component: ' + compSpec.name + '\nKnown: [' + $_et458cx0jcq8hab6.keys(placeholders) + ']\nNamespace: ' + owner.getOr('none') + '\nSpec: ' + $_2k7xfnxfjcq8had9.stringify(compSpec, null, 2));
    }, function (newSpec) {
      return newSpec.replace();
    });
  };
  var scan = function (owner, detail, compSpec, placeholders) {
    if (compSpec.uiType === placeholder)
      return subPlaceholder(owner, detail, compSpec, placeholders);
    else
      return adt$3.single(false, $_dh3z58wbjcq8ha9h.constant(compSpec));
  };
  var substitute = function (owner, detail, compSpec, placeholders) {
    var base = scan(owner, detail, compSpec, placeholders);
    return base.fold(function (req, valueThunk) {
      var value = valueThunk(detail, compSpec.config, compSpec.validated);
      var childSpecs = $_f2tmkex6jcq8hach.readOptFrom(value, 'components').getOr([]);
      var substituted = $_dojsh2w9jcq8ha93.bind(childSpecs, function (c) {
        return substitute(owner, detail, c, placeholders);
      });
      return [$_936c00wyjcq8hab3.deepMerge(value, { components: substituted })];
    }, function (req, valuesThunk) {
      var values = valuesThunk(detail, compSpec.config, compSpec.validated);
      return values;
    });
  };
  var substituteAll = function (owner, detail, components, placeholders) {
    return $_dojsh2w9jcq8ha93.bind(components, function (c) {
      return substitute(owner, detail, c, placeholders);
    });
  };
  var oneReplace = function (label, replacements) {
    var called = false;
    var used = function () {
      return called;
    };
    var replace = function () {
      if (called === true)
        throw new Error('Trying to use the same placeholder more than once: ' + label);
      called = true;
      return replacements;
    };
    var required = function () {
      return replacements.fold(function (req, _) {
        return req;
      }, function (req, _) {
        return req;
      });
    };
    return {
      name: $_dh3z58wbjcq8ha9h.constant(label),
      required: required,
      used: used,
      replace: replace
    };
  };
  var substitutePlaces = function (owner, detail, components, placeholders) {
    var ps = $_et458cx0jcq8hab6.map(placeholders, function (ph, name) {
      return oneReplace(name, ph);
    });
    var outcome = substituteAll(owner, detail, components, ps);
    $_et458cx0jcq8hab6.each(ps, function (p) {
      if (p.used() === false && p.required()) {
        throw new Error('Placeholder: ' + p.name() + ' was not found in components list\nNamespace: ' + owner.getOr('none') + '\nComponents: ' + $_2k7xfnxfjcq8had9.stringify(detail.components(), null, 2));
      }
    });
    return outcome;
  };
  var singleReplace = function (detail, p) {
    var replacement = p;
    return replacement.fold(function (req, valueThunk) {
      return [valueThunk(detail)];
    }, function (req, valuesThunk) {
      return valuesThunk(detail);
    });
  };
  var $_35uhxa10ljcq8havr = {
    single: adt$3.single,
    multiple: adt$3.multiple,
    isSubstitute: isSubstitute,
    placeholder: $_dh3z58wbjcq8ha9h.constant(placeholder),
    substituteAll: substituteAll,
    substitutePlaces: substitutePlaces,
    singleReplace: singleReplace
  };

  var combine = function (detail, data, partSpec, partValidated) {
    var spec = partSpec;
    return $_936c00wyjcq8hab3.deepMerge(data.defaults()(detail, partSpec, partValidated), partSpec, { uid: detail.partUids()[data.name()] }, data.overrides()(detail, partSpec, partValidated), { 'debug.sketcher': $_f2tmkex6jcq8hach.wrap('part-' + data.name(), spec) });
  };
  var subs = function (owner, detail, parts) {
    var internals = {};
    var externals = {};
    $_dojsh2w9jcq8ha93.each(parts, function (part) {
      part.fold(function (data) {
        internals[data.pname()] = $_35uhxa10ljcq8havr.single(true, function (detail, partSpec, partValidated) {
          return data.factory().sketch(combine(detail, data, partSpec, partValidated));
        });
      }, function (data) {
        var partSpec = detail.parts()[data.name()]();
        externals[data.name()] = $_dh3z58wbjcq8ha9h.constant(combine(detail, data, partSpec[$_50i5hr10kjcq8havc.original()]()));
      }, function (data) {
        internals[data.pname()] = $_35uhxa10ljcq8havr.single(false, function (detail, partSpec, partValidated) {
          return data.factory().sketch(combine(detail, data, partSpec, partValidated));
        });
      }, function (data) {
        internals[data.pname()] = $_35uhxa10ljcq8havr.multiple(true, function (detail, _partSpec, _partValidated) {
          var units = detail[data.name()]();
          return $_dojsh2w9jcq8ha93.map(units, function (u) {
            return data.factory().sketch($_936c00wyjcq8hab3.deepMerge(data.defaults()(detail, u), u, data.overrides()(detail, u)));
          });
        });
      });
    });
    return {
      internals: $_dh3z58wbjcq8ha9h.constant(internals),
      externals: $_dh3z58wbjcq8ha9h.constant(externals)
    };
  };
  var $_d3a3j810jjcq8hav6 = { subs: subs };

  var generate$2 = function (owner, parts) {
    var r = {};
    $_dojsh2w9jcq8ha93.each(parts, function (part) {
      $_50i5hr10kjcq8havc.asNamedPart(part).each(function (np) {
        var g = doGenerateOne(owner, np.pname());
        r[np.name()] = function (config) {
          var validated = $_g540acxhjcq8hadd.asRawOrDie('Part: ' + np.name() + ' in ' + owner, $_g540acxhjcq8hadd.objOf(np.schema()), config);
          return $_936c00wyjcq8hab3.deepMerge(g, {
            config: config,
            validated: validated
          });
        };
      });
    });
    return r;
  };
  var doGenerateOne = function (owner, pname) {
    return {
      uiType: $_35uhxa10ljcq8havr.placeholder(),
      owner: owner,
      name: pname
    };
  };
  var generateOne = function (owner, pname, config) {
    return {
      uiType: $_35uhxa10ljcq8havr.placeholder(),
      owner: owner,
      name: pname,
      config: config,
      validated: {}
    };
  };
  var schemas = function (parts) {
    return $_dojsh2w9jcq8ha93.bind(parts, function (part) {
      return part.fold($_9m6n87wajcq8ha9e.none, $_9m6n87wajcq8ha9e.some, $_9m6n87wajcq8ha9e.none, $_9m6n87wajcq8ha9e.none).map(function (data) {
        return $_ah67nix2jcq8habi.strictObjOf(data.name(), data.schema().concat([$_fvpuwdytjcq8hanb.snapshot($_50i5hr10kjcq8havc.original())]));
      }).toArray();
    });
  };
  var names = function (parts) {
    return $_dojsh2w9jcq8ha93.map(parts, $_50i5hr10kjcq8havc.name);
  };
  var substitutes = function (owner, detail, parts) {
    return $_d3a3j810jjcq8hav6.subs(owner, detail, parts);
  };
  var components = function (owner, detail, internals) {
    return $_35uhxa10ljcq8havr.substitutePlaces($_9m6n87wajcq8ha9e.some(owner), detail, detail.components(), internals);
  };
  var getPart = function (component, detail, partKey) {
    var uid = detail.partUids()[partKey];
    return component.getSystem().getByUid(uid).toOption();
  };
  var getPartOrDie = function (component, detail, partKey) {
    return getPart(component, detail, partKey).getOrDie('Could not find part: ' + partKey);
  };
  var getParts = function (component, detail, partKeys) {
    var r = {};
    var uids = detail.partUids();
    var system = component.getSystem();
    $_dojsh2w9jcq8ha93.each(partKeys, function (pk) {
      r[pk] = system.getByUid(uids[pk]);
    });
    return $_et458cx0jcq8hab6.map(r, $_dh3z58wbjcq8ha9h.constant);
  };
  var getAllParts = function (component, detail) {
    var system = component.getSystem();
    return $_et458cx0jcq8hab6.map(detail.partUids(), function (pUid, k) {
      return $_dh3z58wbjcq8ha9h.constant(system.getByUid(pUid));
    });
  };
  var getPartsOrDie = function (component, detail, partKeys) {
    var r = {};
    var uids = detail.partUids();
    var system = component.getSystem();
    $_dojsh2w9jcq8ha93.each(partKeys, function (pk) {
      r[pk] = system.getByUid(uids[pk]).getOrDie();
    });
    return $_et458cx0jcq8hab6.map(r, $_dh3z58wbjcq8ha9h.constant);
  };
  var defaultUids = function (baseUid, partTypes) {
    var partNames = names(partTypes);
    return $_f2tmkex6jcq8hach.wrapAll($_dojsh2w9jcq8ha93.map(partNames, function (pn) {
      return {
        key: pn,
        value: baseUid + '-' + pn
      };
    }));
  };
  var defaultUidsSchema = function (partTypes) {
    return $_ah67nix2jcq8habi.field('partUids', 'partUids', $_27p6pex3jcq8habw.mergeWithThunk(function (spec) {
      return defaultUids(spec.uid, partTypes);
    }), $_g540acxhjcq8hadd.anyValue());
  };
  var $_70h8qs10ijcq8haut = {
    generate: generate$2,
    generateOne: generateOne,
    schemas: schemas,
    names: names,
    substitutes: substitutes,
    components: components,
    defaultUids: defaultUids,
    defaultUidsSchema: defaultUidsSchema,
    getAllParts: getAllParts,
    getPart: getPart,
    getPartOrDie: getPartOrDie,
    getParts: getParts,
    getPartsOrDie: getPartsOrDie
  };

  var prefix$2 = 'alloy-id-';
  var idAttr$1 = 'data-alloy-id';
  var $_mgv1e10njcq8hawb = {
    prefix: $_dh3z58wbjcq8ha9h.constant(prefix$2),
    idAttr: $_dh3z58wbjcq8ha9h.constant(idAttr$1)
  };

  var prefix$1 = $_mgv1e10njcq8hawb.prefix();
  var idAttr = $_mgv1e10njcq8hawb.idAttr();
  var write = function (label, elem) {
    var id = $_8zlm8d10gjcq8hauo.generate(prefix$1 + label);
    $_3kyqh4xwjcq8hajw.set(elem, idAttr, id);
    return id;
  };
  var writeOnly = function (elem, uid) {
    $_3kyqh4xwjcq8hajw.set(elem, idAttr, uid);
  };
  var read$2 = function (elem) {
    var id = $_4z03v7xxjcq8hak1.isElement(elem) ? $_3kyqh4xwjcq8hajw.get(elem, idAttr) : null;
    return $_9m6n87wajcq8ha9e.from(id);
  };
  var find$3 = function (container, id) {
    return $_9rnmwhzmjcq8haqn.descendant(container, id);
  };
  var generate$3 = function (prefix) {
    return $_8zlm8d10gjcq8hauo.generate(prefix);
  };
  var revoke = function (elem) {
    $_3kyqh4xwjcq8hajw.remove(elem, idAttr);
  };
  var $_3r222m10mjcq8haw3 = {
    revoke: revoke,
    write: write,
    writeOnly: writeOnly,
    read: read$2,
    find: find$3,
    generate: generate$3,
    attribute: $_dh3z58wbjcq8ha9h.constant(idAttr)
  };

  var getPartsSchema = function (partNames, _optPartNames, _owner) {
    var owner = _owner !== undefined ? _owner : 'Unknown owner';
    var fallbackThunk = function () {
      return [$_fvpuwdytjcq8hanb.output('partUids', {})];
    };
    var optPartNames = _optPartNames !== undefined ? _optPartNames : fallbackThunk();
    if (partNames.length === 0 && optPartNames.length === 0)
      return fallbackThunk();
    var partsSchema = $_ah67nix2jcq8habi.strictObjOf('parts', $_dojsh2w9jcq8ha93.flatten([
      $_dojsh2w9jcq8ha93.map(partNames, $_ah67nix2jcq8habi.strict),
      $_dojsh2w9jcq8ha93.map(optPartNames, function (optPart) {
        return $_ah67nix2jcq8habi.defaulted(optPart, $_35uhxa10ljcq8havr.single(false, function () {
          throw new Error('The optional part: ' + optPart + ' was not specified in the config, but it was used in components');
        }));
      })
    ]));
    var partUidsSchema = $_ah67nix2jcq8habi.state('partUids', function (spec) {
      if (!$_f2tmkex6jcq8hach.hasKey(spec, 'parts')) {
        throw new Error('Part uid definition for owner: ' + owner + ' requires "parts"\nExpected parts: ' + partNames.join(', ') + '\nSpec: ' + $_2k7xfnxfjcq8had9.stringify(spec, null, 2));
      }
      var uids = $_et458cx0jcq8hab6.map(spec.parts, function (v, k) {
        return $_f2tmkex6jcq8hach.readOptFrom(v, 'uid').getOrThunk(function () {
          return spec.uid + '-' + k;
        });
      });
      return uids;
    });
    return [
      partsSchema,
      partUidsSchema
    ];
  };
  var base$1 = function (label, partSchemas, partUidsSchemas, spec) {
    var ps = partSchemas.length > 0 ? [$_ah67nix2jcq8habi.strictObjOf('parts', partSchemas)] : [];
    return ps.concat([
      $_ah67nix2jcq8habi.strict('uid'),
      $_ah67nix2jcq8habi.defaulted('dom', {}),
      $_ah67nix2jcq8habi.defaulted('components', []),
      $_fvpuwdytjcq8hanb.snapshot('originalSpec'),
      $_ah67nix2jcq8habi.defaulted('debug.sketcher', {})
    ]).concat(partUidsSchemas);
  };
  var asRawOrDie$1 = function (label, schema, spec, partSchemas, partUidsSchemas) {
    var baseS = base$1(label, partSchemas, spec, partUidsSchemas);
    return $_g540acxhjcq8hadd.asRawOrDie(label + ' [SpecSchema]', $_g540acxhjcq8hadd.objOfOnly(baseS.concat(schema)), spec);
  };
  var asStructOrDie$1 = function (label, schema, spec, partSchemas, partUidsSchemas) {
    var baseS = base$1(label, partSchemas, partUidsSchemas, spec);
    return $_g540acxhjcq8hadd.asStructOrDie(label + ' [SpecSchema]', $_g540acxhjcq8hadd.objOfOnly(baseS.concat(schema)), spec);
  };
  var extend = function (builder, original, nu) {
    var newSpec = $_936c00wyjcq8hab3.deepMerge(original, nu);
    return builder(newSpec);
  };
  var addBehaviours = function (original, behaviours) {
    return $_936c00wyjcq8hab3.deepMerge(original, behaviours);
  };
  var $_etzqcb10ojcq8hawe = {
    asRawOrDie: asRawOrDie$1,
    asStructOrDie: asStructOrDie$1,
    addBehaviours: addBehaviours,
    getPartsSchema: getPartsSchema,
    extend: extend
  };

  var single$1 = function (owner, schema, factory, spec) {
    var specWithUid = supplyUid(spec);
    var detail = $_etzqcb10ojcq8hawe.asStructOrDie(owner, schema, specWithUid, [], []);
    return $_936c00wyjcq8hab3.deepMerge(factory(detail, specWithUid), { 'debug.sketcher': $_f2tmkex6jcq8hach.wrap(owner, spec) });
  };
  var composite$1 = function (owner, schema, partTypes, factory, spec) {
    var specWithUid = supplyUid(spec);
    var partSchemas = $_70h8qs10ijcq8haut.schemas(partTypes);
    var partUidsSchema = $_70h8qs10ijcq8haut.defaultUidsSchema(partTypes);
    var detail = $_etzqcb10ojcq8hawe.asStructOrDie(owner, schema, specWithUid, partSchemas, [partUidsSchema]);
    var subs = $_70h8qs10ijcq8haut.substitutes(owner, detail, partTypes);
    var components = $_70h8qs10ijcq8haut.components(owner, detail, subs.internals());
    return $_936c00wyjcq8hab3.deepMerge(factory(detail, components, specWithUid, subs.externals()), { 'debug.sketcher': $_f2tmkex6jcq8hach.wrap(owner, spec) });
  };
  var supplyUid = function (spec) {
    return $_936c00wyjcq8hab3.deepMerge({ uid: $_3r222m10mjcq8haw3.generate('uid') }, spec);
  };
  var $_einy8o10hjcq8haup = {
    supplyUid: supplyUid,
    single: single$1,
    composite: composite$1
  };

  var singleSchema = $_g540acxhjcq8hadd.objOfOnly([
    $_ah67nix2jcq8habi.strict('name'),
    $_ah67nix2jcq8habi.strict('factory'),
    $_ah67nix2jcq8habi.strict('configFields'),
    $_ah67nix2jcq8habi.defaulted('apis', {}),
    $_ah67nix2jcq8habi.defaulted('extraApis', {})
  ]);
  var compositeSchema = $_g540acxhjcq8hadd.objOfOnly([
    $_ah67nix2jcq8habi.strict('name'),
    $_ah67nix2jcq8habi.strict('factory'),
    $_ah67nix2jcq8habi.strict('configFields'),
    $_ah67nix2jcq8habi.strict('partFields'),
    $_ah67nix2jcq8habi.defaulted('apis', {}),
    $_ah67nix2jcq8habi.defaulted('extraApis', {})
  ]);
  var single = function (rawConfig) {
    var config = $_g540acxhjcq8hadd.asRawOrDie('Sketcher for ' + rawConfig.name, singleSchema, rawConfig);
    var sketch = function (spec) {
      return $_einy8o10hjcq8haup.single(config.name, config.configFields, config.factory, spec);
    };
    var apis = $_et458cx0jcq8hab6.map(config.apis, $_edxw3210fjcq8hauj.makeApi);
    var extraApis = $_et458cx0jcq8hab6.map(config.extraApis, function (f, k) {
      return $_2ufx5exjjcq8haiz.markAsExtraApi(f, k);
    });
    return $_936c00wyjcq8hab3.deepMerge({
      name: $_dh3z58wbjcq8ha9h.constant(config.name),
      partFields: $_dh3z58wbjcq8ha9h.constant([]),
      configFields: $_dh3z58wbjcq8ha9h.constant(config.configFields),
      sketch: sketch
    }, apis, extraApis);
  };
  var composite = function (rawConfig) {
    var config = $_g540acxhjcq8hadd.asRawOrDie('Sketcher for ' + rawConfig.name, compositeSchema, rawConfig);
    var sketch = function (spec) {
      return $_einy8o10hjcq8haup.composite(config.name, config.configFields, config.partFields, config.factory, spec);
    };
    var parts = $_70h8qs10ijcq8haut.generate(config.name, config.partFields);
    var apis = $_et458cx0jcq8hab6.map(config.apis, $_edxw3210fjcq8hauj.makeApi);
    var extraApis = $_et458cx0jcq8hab6.map(config.extraApis, function (f, k) {
      return $_2ufx5exjjcq8haiz.markAsExtraApi(f, k);
    });
    return $_936c00wyjcq8hab3.deepMerge({
      name: $_dh3z58wbjcq8ha9h.constant(config.name),
      partFields: $_dh3z58wbjcq8ha9h.constant(config.partFields),
      configFields: $_dh3z58wbjcq8ha9h.constant(config.configFields),
      sketch: sketch,
      parts: $_dh3z58wbjcq8ha9h.constant(parts)
    }, apis, extraApis);
  };
  var $_cocv7l10ejcq8hauc = {
    single: single,
    composite: composite
  };

  var events$4 = function (optAction) {
    var executeHandler = function (action) {
      return $_dkbc99w6jcq8ha8p.run($_51ilu1wwjcq8haax.execute(), function (component, simulatedEvent) {
        action(component);
        simulatedEvent.stop();
      });
    };
    var onClick = function (component, simulatedEvent) {
      simulatedEvent.stop();
      $_3yqf3awvjcq8haat.emitExecute(component);
    };
    var onMousedown = function (component, simulatedEvent) {
      simulatedEvent.cut();
    };
    var pointerEvents = $_6a5cn8wgjcq8ha9o.detect().deviceType.isTouch() ? [$_dkbc99w6jcq8ha8p.run($_51ilu1wwjcq8haax.tap(), onClick)] : [
      $_dkbc99w6jcq8ha8p.run($_gcr2umwxjcq8hab1.click(), onClick),
      $_dkbc99w6jcq8ha8p.run($_gcr2umwxjcq8hab1.mousedown(), onMousedown)
    ];
    return $_dkbc99w6jcq8ha8p.derive($_dojsh2w9jcq8ha93.flatten([
      optAction.map(executeHandler).toArray(),
      pointerEvents
    ]));
  };
  var $_8pigp110pjcq8hawp = { events: events$4 };

  var factory = function (detail, spec) {
    var events = $_8pigp110pjcq8hawp.events(detail.action());
    var optType = $_f2tmkex6jcq8hach.readOptFrom(detail.dom(), 'attributes').bind($_f2tmkex6jcq8hach.readOpt('type'));
    var optTag = $_f2tmkex6jcq8hach.readOptFrom(detail.dom(), 'tag');
    return {
      uid: detail.uid(),
      dom: detail.dom(),
      components: detail.components(),
      events: events,
      behaviours: $_936c00wyjcq8hab3.deepMerge($_bfiithw4jcq8ha84.derive([
        Focusing.config({}),
        Keying.config({
          mode: 'execution',
          useSpace: true,
          useEnter: true
        })
      ]), $_b4pjyg10djcq8hau7.get(detail.buttonBehaviours())),
      domModification: {
        attributes: $_936c00wyjcq8hab3.deepMerge(optType.fold(function () {
          return optTag.is('button') ? { type: 'button' } : {};
        }, function (t) {
          return {};
        }), { role: detail.role().getOr('button') })
      },
      eventOrder: detail.eventOrder()
    };
  };
  var Button = $_cocv7l10ejcq8hauc.single({
    name: 'Button',
    factory: factory,
    configFields: [
      $_ah67nix2jcq8habi.defaulted('uid', undefined),
      $_ah67nix2jcq8habi.strict('dom'),
      $_ah67nix2jcq8habi.defaulted('components', []),
      $_b4pjyg10djcq8hau7.field('buttonBehaviours', [
        Focusing,
        Keying
      ]),
      $_ah67nix2jcq8habi.option('action'),
      $_ah67nix2jcq8habi.option('role'),
      $_ah67nix2jcq8habi.defaulted('eventOrder', {})
    ]
  });

  var getAttrs = function (elem) {
    var attributes = elem.dom().attributes !== undefined ? elem.dom().attributes : [];
    return $_dojsh2w9jcq8ha93.foldl(attributes, function (b, attr) {
      if (attr.name === 'class')
        return b;
      else
        return $_936c00wyjcq8hab3.deepMerge(b, $_f2tmkex6jcq8hach.wrap(attr.name, attr.value));
    }, {});
  };
  var getClasses = function (elem) {
    return Array.prototype.slice.call(elem.dom().classList, 0);
  };
  var fromHtml$2 = function (html) {
    var elem = $_1t8d5wwtjcq8haao.fromHtml(html);
    var children = $_4h5j2xy3jcq8hakl.children(elem);
    var attrs = getAttrs(elem);
    var classes = getClasses(elem);
    var contents = children.length === 0 ? {} : { innerHtml: $_69dru8ybjcq8hals.get(elem) };
    return $_936c00wyjcq8hab3.deepMerge({
      tag: $_4z03v7xxjcq8hak1.name(elem),
      classes: classes,
      attributes: attrs
    }, contents);
  };
  var sketch = function (sketcher, html, config) {
    return sketcher.sketch($_936c00wyjcq8hab3.deepMerge({ dom: fromHtml$2(html) }, config));
  };
  var $_9sr8vq10rjcq8haww = {
    fromHtml: fromHtml$2,
    sketch: sketch
  };

  var dom$1 = function (rawHtml) {
    var html = $_1llmbzwpjcq8haag.supplant(rawHtml, { prefix: $_30duqlz1jcq8haoh.prefix() });
    return $_9sr8vq10rjcq8haww.fromHtml(html);
  };
  var spec = function (rawHtml) {
    var sDom = dom$1(rawHtml);
    return { dom: sDom };
  };
  var $_21mxhc10qjcq8hawt = {
    dom: dom$1,
    spec: spec
  };

  var forToolbarCommand = function (editor, command) {
    return forToolbar(command, function () {
      editor.execCommand(command);
    }, {});
  };
  var getToggleBehaviours = function (command) {
    return $_bfiithw4jcq8ha84.derive([
      Toggling.config({
        toggleClass: $_30duqlz1jcq8haoh.resolve('toolbar-button-selected'),
        toggleOnExecute: false,
        aria: { mode: 'pressed' }
      }),
      $_dnir0tz0jcq8hao8.format(command, function (button, status) {
        var toggle = status ? Toggling.on : Toggling.off;
        toggle(button);
      })
    ]);
  };
  var forToolbarStateCommand = function (editor, command) {
    var extraBehaviours = getToggleBehaviours(command);
    return forToolbar(command, function () {
      editor.execCommand(command);
    }, extraBehaviours);
  };
  var forToolbarStateAction = function (editor, clazz, command, action) {
    var extraBehaviours = getToggleBehaviours(command);
    return forToolbar(clazz, action, extraBehaviours);
  };
  var forToolbar = function (clazz, action, extraBehaviours) {
    return Button.sketch({
      dom: $_21mxhc10qjcq8hawt.dom('<span class="${prefix}-toolbar-button ${prefix}-icon-' + clazz + ' ${prefix}-icon"></span>'),
      action: action,
      buttonBehaviours: $_936c00wyjcq8hab3.deepMerge($_bfiithw4jcq8ha84.derive([Unselecting.config({})]), extraBehaviours)
    });
  };
  var $_378a61z2jcq8haoj = {
    forToolbar: forToolbar,
    forToolbarCommand: forToolbarCommand,
    forToolbarStateAction: forToolbarStateAction,
    forToolbarStateCommand: forToolbarStateCommand
  };

  var reduceBy = function (value, min, max, step) {
    if (value < min)
      return value;
    else if (value > max)
      return max;
    else if (value === min)
      return min - 1;
    else
      return Math.max(min, value - step);
  };
  var increaseBy = function (value, min, max, step) {
    if (value > max)
      return value;
    else if (value < min)
      return min;
    else if (value === max)
      return max + 1;
    else
      return Math.min(max, value + step);
  };
  var capValue = function (value, min, max) {
    return Math.max(min, Math.min(max, value));
  };
  var snapValueOfX = function (bounds, value, min, max, step, snapStart) {
    return snapStart.fold(function () {
      var initValue = value - min;
      var extraValue = Math.round(initValue / step) * step;
      return capValue(min + extraValue, min - 1, max + 1);
    }, function (start) {
      var remainder = (value - start) % step;
      var adjustment = Math.round(remainder / step);
      var rawSteps = Math.floor((value - start) / step);
      var maxSteps = Math.floor((max - start) / step);
      var numSteps = Math.min(maxSteps, rawSteps + adjustment);
      var r = start + numSteps * step;
      return Math.max(start, r);
    });
  };
  var findValueOfX = function (bounds, min, max, xValue, step, snapToGrid, snapStart) {
    var range = max - min;
    if (xValue < bounds.left)
      return min - 1;
    else if (xValue > bounds.right)
      return max + 1;
    else {
      var xOffset = Math.min(bounds.right, Math.max(xValue, bounds.left)) - bounds.left;
      var newValue = capValue(xOffset / bounds.width * range + min, min - 1, max + 1);
      var roundedValue = Math.round(newValue);
      return snapToGrid && newValue >= min && newValue <= max ? snapValueOfX(bounds, newValue, min, max, step, snapStart) : roundedValue;
    }
  };
  var $_bph6ht10wjcq8haxz = {
    reduceBy: reduceBy,
    increaseBy: increaseBy,
    findValueOfX: findValueOfX
  };

  var changeEvent = 'slider.change.value';
  var isTouch$1 = $_6a5cn8wgjcq8ha9o.detect().deviceType.isTouch();
  var getEventSource = function (simulatedEvent) {
    var evt = simulatedEvent.event().raw();
    if (isTouch$1 && evt.touches !== undefined && evt.touches.length === 1)
      return $_9m6n87wajcq8ha9e.some(evt.touches[0]);
    else if (isTouch$1 && evt.touches !== undefined)
      return $_9m6n87wajcq8ha9e.none();
    else if (!isTouch$1 && evt.clientX !== undefined)
      return $_9m6n87wajcq8ha9e.some(evt);
    else
      return $_9m6n87wajcq8ha9e.none();
  };
  var getEventX = function (simulatedEvent) {
    var spot = getEventSource(simulatedEvent);
    return spot.map(function (s) {
      return s.clientX;
    });
  };
  var fireChange = function (component, value) {
    $_3yqf3awvjcq8haat.emitWith(component, changeEvent, { value: value });
  };
  var moveRightFromLedge = function (ledge, detail) {
    fireChange(ledge, detail.min());
  };
  var moveLeftFromRedge = function (redge, detail) {
    fireChange(redge, detail.max());
  };
  var setToRedge = function (redge, detail) {
    fireChange(redge, detail.max() + 1);
  };
  var setToLedge = function (ledge, detail) {
    fireChange(ledge, detail.min() - 1);
  };
  var setToX = function (spectrum, spectrumBounds, detail, xValue) {
    var value = $_bph6ht10wjcq8haxz.findValueOfX(spectrumBounds, detail.min(), detail.max(), xValue, detail.stepSize(), detail.snapToGrid(), detail.snapStart());
    fireChange(spectrum, value);
  };
  var setXFromEvent = function (spectrum, detail, spectrumBounds, simulatedEvent) {
    return getEventX(simulatedEvent).map(function (xValue) {
      setToX(spectrum, spectrumBounds, detail, xValue);
      return xValue;
    });
  };
  var moveLeft$4 = function (spectrum, detail) {
    var newValue = $_bph6ht10wjcq8haxz.reduceBy(detail.value().get(), detail.min(), detail.max(), detail.stepSize());
    fireChange(spectrum, newValue);
  };
  var moveRight$4 = function (spectrum, detail) {
    var newValue = $_bph6ht10wjcq8haxz.increaseBy(detail.value().get(), detail.min(), detail.max(), detail.stepSize());
    fireChange(spectrum, newValue);
  };
  var $_45w3no10vjcq8haxp = {
    setXFromEvent: setXFromEvent,
    setToLedge: setToLedge,
    setToRedge: setToRedge,
    moveLeftFromRedge: moveLeftFromRedge,
    moveRightFromLedge: moveRightFromLedge,
    moveLeft: moveLeft$4,
    moveRight: moveRight$4,
    changeEvent: $_dh3z58wbjcq8ha9h.constant(changeEvent)
  };

  var platform = $_6a5cn8wgjcq8ha9o.detect();
  var isTouch = platform.deviceType.isTouch();
  var edgePart = function (name, action) {
    return $_50i5hr10kjcq8havc.optional({
      name: '' + name + '-edge',
      overrides: function (detail) {
        var touchEvents = $_dkbc99w6jcq8ha8p.derive([$_dkbc99w6jcq8ha8p.runActionExtra($_gcr2umwxjcq8hab1.touchstart(), action, [detail])]);
        var mouseEvents = $_dkbc99w6jcq8ha8p.derive([
          $_dkbc99w6jcq8ha8p.runActionExtra($_gcr2umwxjcq8hab1.mousedown(), action, [detail]),
          $_dkbc99w6jcq8ha8p.runActionExtra($_gcr2umwxjcq8hab1.mousemove(), function (l, det) {
            if (det.mouseIsDown().get())
              action(l, det);
          }, [detail])
        ]);
        return { events: isTouch ? touchEvents : mouseEvents };
      }
    });
  };
  var ledgePart = edgePart('left', $_45w3no10vjcq8haxp.setToLedge);
  var redgePart = edgePart('right', $_45w3no10vjcq8haxp.setToRedge);
  var thumbPart = $_50i5hr10kjcq8havc.required({
    name: 'thumb',
    defaults: $_dh3z58wbjcq8ha9h.constant({ dom: { styles: { position: 'absolute' } } }),
    overrides: function (detail) {
      return {
        events: $_dkbc99w6jcq8ha8p.derive([
          $_dkbc99w6jcq8ha8p.redirectToPart($_gcr2umwxjcq8hab1.touchstart(), detail, 'spectrum'),
          $_dkbc99w6jcq8ha8p.redirectToPart($_gcr2umwxjcq8hab1.touchmove(), detail, 'spectrum'),
          $_dkbc99w6jcq8ha8p.redirectToPart($_gcr2umwxjcq8hab1.touchend(), detail, 'spectrum')
        ])
      };
    }
  });
  var spectrumPart = $_50i5hr10kjcq8havc.required({
    schema: [$_ah67nix2jcq8habi.state('mouseIsDown', function () {
        return Cell(false);
      })],
    name: 'spectrum',
    overrides: function (detail) {
      var moveToX = function (spectrum, simulatedEvent) {
        var spectrumBounds = spectrum.element().dom().getBoundingClientRect();
        $_45w3no10vjcq8haxp.setXFromEvent(spectrum, detail, spectrumBounds, simulatedEvent);
      };
      var touchEvents = $_dkbc99w6jcq8ha8p.derive([
        $_dkbc99w6jcq8ha8p.run($_gcr2umwxjcq8hab1.touchstart(), moveToX),
        $_dkbc99w6jcq8ha8p.run($_gcr2umwxjcq8hab1.touchmove(), moveToX)
      ]);
      var mouseEvents = $_dkbc99w6jcq8ha8p.derive([
        $_dkbc99w6jcq8ha8p.run($_gcr2umwxjcq8hab1.mousedown(), moveToX),
        $_dkbc99w6jcq8ha8p.run($_gcr2umwxjcq8hab1.mousemove(), function (spectrum, se) {
          if (detail.mouseIsDown().get())
            moveToX(spectrum, se);
        })
      ]);
      return {
        behaviours: $_bfiithw4jcq8ha84.derive(isTouch ? [] : [
          Keying.config({
            mode: 'special',
            onLeft: function (spectrum) {
              $_45w3no10vjcq8haxp.moveLeft(spectrum, detail);
              return $_9m6n87wajcq8ha9e.some(true);
            },
            onRight: function (spectrum) {
              $_45w3no10vjcq8haxp.moveRight(spectrum, detail);
              return $_9m6n87wajcq8ha9e.some(true);
            }
          }),
          Focusing.config({})
        ]),
        events: isTouch ? touchEvents : mouseEvents
      };
    }
  });
  var SliderParts = [
    ledgePart,
    redgePart,
    thumbPart,
    spectrumPart
  ];

  var onLoad$1 = function (component, repConfig, repState) {
    repConfig.store().manager().onLoad(component, repConfig, repState);
  };
  var onUnload = function (component, repConfig, repState) {
    repConfig.store().manager().onUnload(component, repConfig, repState);
  };
  var setValue = function (component, repConfig, repState, data) {
    repConfig.store().manager().setValue(component, repConfig, repState, data);
  };
  var getValue = function (component, repConfig, repState) {
    return repConfig.store().manager().getValue(component, repConfig, repState);
  };
  var $_6hetga110jcq8haya = {
    onLoad: onLoad$1,
    onUnload: onUnload,
    setValue: setValue,
    getValue: getValue
  };

  var events$5 = function (repConfig, repState) {
    var es = repConfig.resetOnDom() ? [
      $_dkbc99w6jcq8ha8p.runOnAttached(function (comp, se) {
        $_6hetga110jcq8haya.onLoad(comp, repConfig, repState);
      }),
      $_dkbc99w6jcq8ha8p.runOnDetached(function (comp, se) {
        $_6hetga110jcq8haya.onUnload(comp, repConfig, repState);
      })
    ] : [$_1oalwmw5jcq8ha8c.loadEvent(repConfig, repState, $_6hetga110jcq8haya.onLoad)];
    return $_dkbc99w6jcq8ha8p.derive(es);
  };
  var $_bjqx2a10zjcq8hay8 = { events: events$5 };

  var memory = function () {
    var data = Cell(null);
    var readState = function () {
      return {
        mode: 'memory',
        value: data.get()
      };
    };
    var isNotSet = function () {
      return data.get() === null;
    };
    var clear = function () {
      data.set(null);
    };
    return BehaviourState({
      set: data.set,
      get: data.get,
      isNotSet: isNotSet,
      clear: clear,
      readState: readState
    });
  };
  var manual = function () {
    var readState = function () {
    };
    return BehaviourState({ readState: readState });
  };
  var dataset = function () {
    var data = Cell({});
    var readState = function () {
      return {
        mode: 'dataset',
        dataset: data.get()
      };
    };
    return BehaviourState({
      readState: readState,
      set: data.set,
      get: data.get
    });
  };
  var init$2 = function (spec) {
    return spec.store().manager().state(spec);
  };
  var $_a5ib02113jcq8hayi = {
    memory: memory,
    dataset: dataset,
    manual: manual,
    init: init$2
  };

  var setValue$1 = function (component, repConfig, repState, data) {
    var dataKey = repConfig.store().getDataKey();
    repState.set({});
    repConfig.store().setData()(component, data);
    repConfig.onSetValue()(component, data);
  };
  var getValue$1 = function (component, repConfig, repState) {
    var key = repConfig.store().getDataKey()(component);
    var dataset = repState.get();
    return $_f2tmkex6jcq8hach.readOptFrom(dataset, key).fold(function () {
      return repConfig.store().getFallbackEntry()(key);
    }, function (data) {
      return data;
    });
  };
  var onLoad$2 = function (component, repConfig, repState) {
    repConfig.store().initialValue().each(function (data) {
      setValue$1(component, repConfig, repState, data);
    });
  };
  var onUnload$1 = function (component, repConfig, repState) {
    repState.set({});
  };
  var DatasetStore = [
    $_ah67nix2jcq8habi.option('initialValue'),
    $_ah67nix2jcq8habi.strict('getFallbackEntry'),
    $_ah67nix2jcq8habi.strict('getDataKey'),
    $_ah67nix2jcq8habi.strict('setData'),
    $_fvpuwdytjcq8hanb.output('manager', {
      setValue: setValue$1,
      getValue: getValue$1,
      onLoad: onLoad$2,
      onUnload: onUnload$1,
      state: $_a5ib02113jcq8hayi.dataset
    })
  ];

  var getValue$2 = function (component, repConfig, repState) {
    return repConfig.store().getValue()(component);
  };
  var setValue$2 = function (component, repConfig, repState, data) {
    repConfig.store().setValue()(component, data);
    repConfig.onSetValue()(component, data);
  };
  var onLoad$3 = function (component, repConfig, repState) {
    repConfig.store().initialValue().each(function (data) {
      repConfig.store().setValue()(component, data);
    });
  };
  var ManualStore = [
    $_ah67nix2jcq8habi.strict('getValue'),
    $_ah67nix2jcq8habi.defaulted('setValue', $_dh3z58wbjcq8ha9h.noop),
    $_ah67nix2jcq8habi.option('initialValue'),
    $_fvpuwdytjcq8hanb.output('manager', {
      setValue: setValue$2,
      getValue: getValue$2,
      onLoad: onLoad$3,
      onUnload: $_dh3z58wbjcq8ha9h.noop,
      state: $_6dyjy2xqjcq8hajl.init
    })
  ];

  var setValue$3 = function (component, repConfig, repState, data) {
    repState.set(data);
    repConfig.onSetValue()(component, data);
  };
  var getValue$3 = function (component, repConfig, repState) {
    return repState.get();
  };
  var onLoad$4 = function (component, repConfig, repState) {
    repConfig.store().initialValue().each(function (initVal) {
      if (repState.isNotSet())
        repState.set(initVal);
    });
  };
  var onUnload$2 = function (component, repConfig, repState) {
    repState.clear();
  };
  var MemoryStore = [
    $_ah67nix2jcq8habi.option('initialValue'),
    $_fvpuwdytjcq8hanb.output('manager', {
      setValue: setValue$3,
      getValue: getValue$3,
      onLoad: onLoad$4,
      onUnload: onUnload$2,
      state: $_a5ib02113jcq8hayi.memory
    })
  ];

  var RepresentSchema = [
    $_ah67nix2jcq8habi.defaultedOf('store', { mode: 'memory' }, $_g540acxhjcq8hadd.choose('mode', {
      memory: MemoryStore,
      manual: ManualStore,
      dataset: DatasetStore
    })),
    $_fvpuwdytjcq8hanb.onHandler('onSetValue'),
    $_ah67nix2jcq8habi.defaulted('resetOnDom', false)
  ];

  var me = $_bfiithw4jcq8ha84.create({
    fields: RepresentSchema,
    name: 'representing',
    active: $_bjqx2a10zjcq8hay8,
    apis: $_6hetga110jcq8haya,
    extra: {
      setValueFrom: function (component, source) {
        var value = me.getValue(source);
        me.setValue(component, value);
      }
    },
    state: $_a5ib02113jcq8hayi
  });

  var isTouch$2 = $_6a5cn8wgjcq8ha9o.detect().deviceType.isTouch();
  var SliderSchema = [
    $_ah67nix2jcq8habi.strict('min'),
    $_ah67nix2jcq8habi.strict('max'),
    $_ah67nix2jcq8habi.defaulted('stepSize', 1),
    $_ah67nix2jcq8habi.defaulted('onChange', $_dh3z58wbjcq8ha9h.noop),
    $_ah67nix2jcq8habi.defaulted('onInit', $_dh3z58wbjcq8ha9h.noop),
    $_ah67nix2jcq8habi.defaulted('onDragStart', $_dh3z58wbjcq8ha9h.noop),
    $_ah67nix2jcq8habi.defaulted('onDragEnd', $_dh3z58wbjcq8ha9h.noop),
    $_ah67nix2jcq8habi.defaulted('snapToGrid', false),
    $_ah67nix2jcq8habi.option('snapStart'),
    $_ah67nix2jcq8habi.strict('getInitialValue'),
    $_b4pjyg10djcq8hau7.field('sliderBehaviours', [
      Keying,
      me
    ]),
    $_ah67nix2jcq8habi.state('value', function (spec) {
      return Cell(spec.min);
    })
  ].concat(!isTouch$2 ? [$_ah67nix2jcq8habi.state('mouseIsDown', function () {
      return Cell(false);
    })] : []);

  var api$1 = Dimension('width', function (element) {
    return element.dom().offsetWidth;
  });
  var set$4 = function (element, h) {
    api$1.set(element, h);
  };
  var get$6 = function (element) {
    return api$1.get(element);
  };
  var getOuter$2 = function (element) {
    return api$1.getOuter(element);
  };
  var setMax$1 = function (element, value) {
    var inclusions = [
      'margin-left',
      'border-left-width',
      'padding-left',
      'padding-right',
      'border-right-width',
      'margin-right'
    ];
    var absMax = api$1.max(element, value, inclusions);
    $_bljwzsjcq8har2.set(element, 'max-width', absMax + 'px');
  };
  var $_72au9u117jcq8hazb = {
    set: set$4,
    get: get$6,
    getOuter: getOuter$2,
    setMax: setMax$1
  };

  var isTouch$3 = $_6a5cn8wgjcq8ha9o.detect().deviceType.isTouch();
  var sketch$2 = function (detail, components, spec, externals) {
    var range = detail.max() - detail.min();
    var getXCentre = function (component) {
      var rect = component.element().dom().getBoundingClientRect();
      return (rect.left + rect.right) / 2;
    };
    var getThumb = function (component) {
      return $_70h8qs10ijcq8haut.getPartOrDie(component, detail, 'thumb');
    };
    var getXOffset = function (slider, spectrumBounds, detail) {
      var v = detail.value().get();
      if (v < detail.min()) {
        return $_70h8qs10ijcq8haut.getPart(slider, detail, 'left-edge').fold(function () {
          return 0;
        }, function (ledge) {
          return getXCentre(ledge) - spectrumBounds.left;
        });
      } else if (v > detail.max()) {
        return $_70h8qs10ijcq8haut.getPart(slider, detail, 'right-edge').fold(function () {
          return spectrumBounds.width;
        }, function (redge) {
          return getXCentre(redge) - spectrumBounds.left;
        });
      } else {
        return (detail.value().get() - detail.min()) / range * spectrumBounds.width;
      }
    };
    var getXPos = function (slider) {
      var spectrum = $_70h8qs10ijcq8haut.getPartOrDie(slider, detail, 'spectrum');
      var spectrumBounds = spectrum.element().dom().getBoundingClientRect();
      var sliderBounds = slider.element().dom().getBoundingClientRect();
      var xOffset = getXOffset(slider, spectrumBounds, detail);
      return spectrumBounds.left - sliderBounds.left + xOffset;
    };
    var refresh = function (component) {
      var pos = getXPos(component);
      var thumb = getThumb(component);
      var thumbRadius = $_72au9u117jcq8hazb.get(thumb.element()) / 2;
      $_bljwzsjcq8har2.set(thumb.element(), 'left', pos - thumbRadius + 'px');
    };
    var changeValue = function (component, newValue) {
      var oldValue = detail.value().get();
      var thumb = getThumb(component);
      if (oldValue !== newValue || $_bljwzsjcq8har2.getRaw(thumb.element(), 'left').isNone()) {
        detail.value().set(newValue);
        refresh(component);
        detail.onChange()(component, thumb, newValue);
        return $_9m6n87wajcq8ha9e.some(true);
      } else {
        return $_9m6n87wajcq8ha9e.none();
      }
    };
    var resetToMin = function (slider) {
      changeValue(slider, detail.min());
    };
    var resetToMax = function (slider) {
      changeValue(slider, detail.max());
    };
    var uiEventsArr = isTouch$3 ? [
      $_dkbc99w6jcq8ha8p.run($_gcr2umwxjcq8hab1.touchstart(), function (slider, simulatedEvent) {
        detail.onDragStart()(slider, getThumb(slider));
      }),
      $_dkbc99w6jcq8ha8p.run($_gcr2umwxjcq8hab1.touchend(), function (slider, simulatedEvent) {
        detail.onDragEnd()(slider, getThumb(slider));
      })
    ] : [
      $_dkbc99w6jcq8ha8p.run($_gcr2umwxjcq8hab1.mousedown(), function (slider, simulatedEvent) {
        simulatedEvent.stop();
        detail.onDragStart()(slider, getThumb(slider));
        detail.mouseIsDown().set(true);
      }),
      $_dkbc99w6jcq8ha8p.run($_gcr2umwxjcq8hab1.mouseup(), function (slider, simulatedEvent) {
        detail.onDragEnd()(slider, getThumb(slider));
        detail.mouseIsDown().set(false);
      })
    ];
    return {
      uid: detail.uid(),
      dom: detail.dom(),
      components: components,
      behaviours: $_936c00wyjcq8hab3.deepMerge($_bfiithw4jcq8ha84.derive($_dojsh2w9jcq8ha93.flatten([
        !isTouch$3 ? [Keying.config({
            mode: 'special',
            focusIn: function (slider) {
              return $_70h8qs10ijcq8haut.getPart(slider, detail, 'spectrum').map(Keying.focusIn).map($_dh3z58wbjcq8ha9h.constant(true));
            }
          })] : [],
        [me.config({
            store: {
              mode: 'manual',
              getValue: function (_) {
                return detail.value().get();
              }
            }
          })]
      ])), $_b4pjyg10djcq8hau7.get(detail.sliderBehaviours())),
      events: $_dkbc99w6jcq8ha8p.derive([
        $_dkbc99w6jcq8ha8p.run($_45w3no10vjcq8haxp.changeEvent(), function (slider, simulatedEvent) {
          changeValue(slider, simulatedEvent.event().value());
        }),
        $_dkbc99w6jcq8ha8p.runOnAttached(function (slider, simulatedEvent) {
          detail.value().set(detail.getInitialValue()());
          var thumb = getThumb(slider);
          refresh(slider);
          detail.onInit()(slider, thumb, detail.value().get());
        })
      ].concat(uiEventsArr)),
      apis: {
        resetToMin: resetToMin,
        resetToMax: resetToMax,
        refresh: refresh
      },
      domModification: { styles: { position: 'relative' } }
    };
  };
  var $_8ig97o116jcq8hayt = { sketch: sketch$2 };

  var Slider = $_cocv7l10ejcq8hauc.composite({
    name: 'Slider',
    configFields: SliderSchema,
    partFields: SliderParts,
    factory: $_8ig97o116jcq8hayt.sketch,
    apis: {
      resetToMin: function (apis, slider) {
        apis.resetToMin(slider);
      },
      resetToMax: function (apis, slider) {
        apis.resetToMax(slider);
      },
      refresh: function (apis, slider) {
        apis.refresh(slider);
      }
    }
  });

  var button = function (realm, clazz, makeItems) {
    return $_378a61z2jcq8haoj.forToolbar(clazz, function () {
      var items = makeItems();
      realm.setContextToolbar([{
          label: clazz + ' group',
          items: items
        }]);
    }, {});
  };
  var $_1wuoea118jcq8hazc = { button: button };

  var BLACK = -1;
  var makeSlider = function (spec) {
    var getColor = function (hue) {
      if (hue < 0) {
        return 'black';
      } else if (hue > 360) {
        return 'white';
      } else {
        return 'hsl(' + hue + ', 100%, 50%)';
      }
    };
    var onInit = function (slider, thumb, value) {
      var color = getColor(value);
      $_bljwzsjcq8har2.set(thumb.element(), 'background-color', color);
    };
    var onChange = function (slider, thumb, value) {
      var color = getColor(value);
      $_bljwzsjcq8har2.set(thumb.element(), 'background-color', color);
      spec.onChange(slider, thumb, color);
    };
    return Slider.sketch({
      dom: $_21mxhc10qjcq8hawt.dom('<div class="${prefix}-slider ${prefix}-hue-slider-container"></div>'),
      components: [
        Slider.parts()['left-edge']($_21mxhc10qjcq8hawt.spec('<div class="${prefix}-hue-slider-black"></div>')),
        Slider.parts().spectrum({
          dom: $_21mxhc10qjcq8hawt.dom('<div class="${prefix}-slider-gradient-container"></div>'),
          components: [$_21mxhc10qjcq8hawt.spec('<div class="${prefix}-slider-gradient"></div>')],
          behaviours: $_bfiithw4jcq8ha84.derive([Toggling.config({ toggleClass: $_30duqlz1jcq8haoh.resolve('thumb-active') })])
        }),
        Slider.parts()['right-edge']($_21mxhc10qjcq8hawt.spec('<div class="${prefix}-hue-slider-white"></div>')),
        Slider.parts().thumb({
          dom: $_21mxhc10qjcq8hawt.dom('<div class="${prefix}-slider-thumb"></div>'),
          behaviours: $_bfiithw4jcq8ha84.derive([Toggling.config({ toggleClass: $_30duqlz1jcq8haoh.resolve('thumb-active') })])
        })
      ],
      onChange: onChange,
      onDragStart: function (slider, thumb) {
        Toggling.on(thumb);
      },
      onDragEnd: function (slider, thumb) {
        Toggling.off(thumb);
      },
      onInit: onInit,
      stepSize: 10,
      min: 0,
      max: 360,
      getInitialValue: spec.getInitialValue,
      sliderBehaviours: $_bfiithw4jcq8ha84.derive([$_dnir0tz0jcq8hao8.orientation(Slider.refresh)])
    });
  };
  var makeItems = function (spec) {
    return [makeSlider(spec)];
  };
  var sketch$1 = function (realm, editor) {
    var spec = {
      onChange: function (slider, thumb, color) {
        editor.undoManager.transact(function () {
          editor.formatter.apply('forecolor', { value: color });
          editor.nodeChanged();
        });
      },
      getInitialValue: function () {
        return BLACK;
      }
    };
    return $_1wuoea118jcq8hazc.button(realm, 'color', function () {
      return makeItems(spec);
    });
  };
  var $_dy2ywu10sjcq8haxa = {
    makeItems: makeItems,
    sketch: sketch$1
  };

  var schema$7 = $_g540acxhjcq8hadd.objOfOnly([
    $_ah67nix2jcq8habi.strict('getInitialValue'),
    $_ah67nix2jcq8habi.strict('onChange'),
    $_ah67nix2jcq8habi.strict('category'),
    $_ah67nix2jcq8habi.strict('sizes')
  ]);
  var sketch$4 = function (rawSpec) {
    var spec = $_g540acxhjcq8hadd.asRawOrDie('SizeSlider', schema$7, rawSpec);
    var isValidValue = function (valueIndex) {
      return valueIndex >= 0 && valueIndex < spec.sizes.length;
    };
    var onChange = function (slider, thumb, valueIndex) {
      if (isValidValue(valueIndex)) {
        spec.onChange(valueIndex);
      }
    };
    return Slider.sketch({
      dom: {
        tag: 'div',
        classes: [
          $_30duqlz1jcq8haoh.resolve('slider-' + spec.category + '-size-container'),
          $_30duqlz1jcq8haoh.resolve('slider'),
          $_30duqlz1jcq8haoh.resolve('slider-size-container')
        ]
      },
      onChange: onChange,
      onDragStart: function (slider, thumb) {
        Toggling.on(thumb);
      },
      onDragEnd: function (slider, thumb) {
        Toggling.off(thumb);
      },
      min: 0,
      max: spec.sizes.length - 1,
      stepSize: 1,
      getInitialValue: spec.getInitialValue,
      snapToGrid: true,
      sliderBehaviours: $_bfiithw4jcq8ha84.derive([$_dnir0tz0jcq8hao8.orientation(Slider.refresh)]),
      components: [
        Slider.parts().spectrum({
          dom: $_21mxhc10qjcq8hawt.dom('<div class="${prefix}-slider-size-container"></div>'),
          components: [$_21mxhc10qjcq8hawt.spec('<div class="${prefix}-slider-size-line"></div>')]
        }),
        Slider.parts().thumb({
          dom: $_21mxhc10qjcq8hawt.dom('<div class="${prefix}-slider-thumb"></div>'),
          behaviours: $_bfiithw4jcq8ha84.derive([Toggling.config({ toggleClass: $_30duqlz1jcq8haoh.resolve('thumb-active') })])
        })
      ]
    });
  };
  var $_dcewrk11ajcq8hazf = { sketch: sketch$4 };

  var ancestor$3 = function (scope, transform, isRoot) {
    var element = scope.dom();
    var stop = $_6xn7hbwzjcq8hab5.isFunction(isRoot) ? isRoot : $_dh3z58wbjcq8ha9h.constant(false);
    while (element.parentNode) {
      element = element.parentNode;
      var el = $_1t8d5wwtjcq8haao.fromDom(element);
      var transformed = transform(el);
      if (transformed.isSome())
        return transformed;
      else if (stop(el))
        break;
    }
    return $_9m6n87wajcq8ha9e.none();
  };
  var closest$3 = function (scope, transform, isRoot) {
    var current = transform(scope);
    return current.orThunk(function () {
      return isRoot(scope) ? $_9m6n87wajcq8ha9e.none() : ancestor$3(scope, transform, isRoot);
    });
  };
  var $_1w27qu11cjcq8hazu = {
    ancestor: ancestor$3,
    closest: closest$3
  };

  var candidates = [
    '9px',
    '10px',
    '11px',
    '12px',
    '14px',
    '16px',
    '18px',
    '20px',
    '24px',
    '32px',
    '36px'
  ];
  var defaultSize = 'medium';
  var defaultIndex = 2;
  var indexToSize = function (index) {
    return $_9m6n87wajcq8ha9e.from(candidates[index]);
  };
  var sizeToIndex = function (size) {
    return $_dojsh2w9jcq8ha93.findIndex(candidates, function (v) {
      return v === size;
    });
  };
  var getRawOrComputed = function (isRoot, rawStart) {
    var optStart = $_4z03v7xxjcq8hak1.isElement(rawStart) ? $_9m6n87wajcq8ha9e.some(rawStart) : $_4h5j2xy3jcq8hakl.parent(rawStart);
    return optStart.map(function (start) {
      var inline = $_1w27qu11cjcq8hazu.closest(start, function (elem) {
        return $_bljwzsjcq8har2.getRaw(elem, 'font-size');
      }, isRoot);
      return inline.getOrThunk(function () {
        return $_bljwzsjcq8har2.get(start, 'font-size');
      });
    }).getOr('');
  };
  var getSize = function (editor) {
    var node = editor.selection.getStart();
    var elem = $_1t8d5wwtjcq8haao.fromDom(node);
    var root = $_1t8d5wwtjcq8haao.fromDom(editor.getBody());
    var isRoot = function (e) {
      return $_darej4w8jcq8ha8v.eq(root, e);
    };
    var elemSize = getRawOrComputed(isRoot, elem);
    return $_dojsh2w9jcq8ha93.find(candidates, function (size) {
      return elemSize === size;
    }).getOr(defaultSize);
  };
  var applySize = function (editor, value) {
    var currentValue = getSize(editor);
    if (currentValue !== value) {
      editor.execCommand('fontSize', false, value);
    }
  };
  var get$7 = function (editor) {
    var size = getSize(editor);
    return sizeToIndex(size).getOr(defaultIndex);
  };
  var apply$1 = function (editor, index) {
    indexToSize(index).each(function (size) {
      applySize(editor, size);
    });
  };
  var $_5g0o1411bjcq8hazl = {
    candidates: $_dh3z58wbjcq8ha9h.constant(candidates),
    get: get$7,
    apply: apply$1
  };

  var sizes = $_5g0o1411bjcq8hazl.candidates();
  var makeSlider$1 = function (spec) {
    return $_dcewrk11ajcq8hazf.sketch({
      onChange: spec.onChange,
      sizes: sizes,
      category: 'font',
      getInitialValue: spec.getInitialValue
    });
  };
  var makeItems$1 = function (spec) {
    return [
      $_21mxhc10qjcq8hawt.spec('<span class="${prefix}-toolbar-button ${prefix}-icon-small-font ${prefix}-icon"></span>'),
      makeSlider$1(spec),
      $_21mxhc10qjcq8hawt.spec('<span class="${prefix}-toolbar-button ${prefix}-icon-large-font ${prefix}-icon"></span>')
    ];
  };
  var sketch$3 = function (realm, editor) {
    var spec = {
      onChange: function (value) {
        $_5g0o1411bjcq8hazl.apply(editor, value);
      },
      getInitialValue: function () {
        return $_5g0o1411bjcq8hazl.get(editor);
      }
    };
    return $_1wuoea118jcq8hazc.button(realm, 'font-size', function () {
      return makeItems$1(spec);
    });
  };
  var $_e8ilcd119jcq8hazd = {
    makeItems: makeItems$1,
    sketch: sketch$3
  };

  var record = function (spec) {
    var uid = $_f2tmkex6jcq8hach.hasKey(spec, 'uid') ? spec.uid : $_3r222m10mjcq8haw3.generate('memento');
    var get = function (any) {
      return any.getSystem().getByUid(uid).getOrDie();
    };
    var getOpt = function (any) {
      return any.getSystem().getByUid(uid).fold($_9m6n87wajcq8ha9e.none, $_9m6n87wajcq8ha9e.some);
    };
    var asSpec = function () {
      return $_936c00wyjcq8hab3.deepMerge(spec, { uid: uid });
    };
    return {
      get: get,
      getOpt: getOpt,
      asSpec: asSpec
    };
  };
  var $_4sw8ie11ejcq8hb07 = { record: record };

  function create$3(width, height) {
    return resize(document.createElement('canvas'), width, height);
  }
  function clone$2(canvas) {
    var tCanvas, ctx;
    tCanvas = create$3(canvas.width, canvas.height);
    ctx = get2dContext(tCanvas);
    ctx.drawImage(canvas, 0, 0);
    return tCanvas;
  }
  function get2dContext(canvas) {
    return canvas.getContext('2d');
  }
  function get3dContext(canvas) {
    var gl = null;
    try {
      gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
    } catch (e) {
    }
    if (!gl) {
      gl = null;
    }
    return gl;
  }
  function resize(canvas, width, height) {
    canvas.width = width;
    canvas.height = height;
    return canvas;
  }
  var $_dgg38111hjcq8hb0u = {
    create: create$3,
    clone: clone$2,
    resize: resize,
    get2dContext: get2dContext,
    get3dContext: get3dContext
  };

  function getWidth(image) {
    return image.naturalWidth || image.width;
  }
  function getHeight(image) {
    return image.naturalHeight || image.height;
  }
  var $_fstwbk11ijcq8hb0v = {
    getWidth: getWidth,
    getHeight: getHeight
  };

  var promise = function () {
    var Promise = function (fn) {
      if (typeof this !== 'object')
        throw new TypeError('Promises must be constructed via new');
      if (typeof fn !== 'function')
        throw new TypeError('not a function');
      this._state = null;
      this._value = null;
      this._deferreds = [];
      doResolve(fn, bind(resolve, this), bind(reject, this));
    };
    var asap = Promise.immediateFn || typeof setImmediate === 'function' && setImmediate || function (fn) {
      setTimeout(fn, 1);
    };
    function bind(fn, thisArg) {
      return function () {
        fn.apply(thisArg, arguments);
      };
    }
    var isArray = Array.isArray || function (value) {
      return Object.prototype.toString.call(value) === '[object Array]';
    };
    function handle(deferred) {
      var me = this;
      if (this._state === null) {
        this._deferreds.push(deferred);
        return;
      }
      asap(function () {
        var cb = me._state ? deferred.onFulfilled : deferred.onRejected;
        if (cb === null) {
          (me._state ? deferred.resolve : deferred.reject)(me._value);
          return;
        }
        var ret;
        try {
          ret = cb(me._value);
        } catch (e) {
          deferred.reject(e);
          return;
        }
        deferred.resolve(ret);
      });
    }
    function resolve(newValue) {
      try {
        if (newValue === this)
          throw new TypeError('A promise cannot be resolved with itself.');
        if (newValue && (typeof newValue === 'object' || typeof newValue === 'function')) {
          var then = newValue.then;
          if (typeof then === 'function') {
            doResolve(bind(then, newValue), bind(resolve, this), bind(reject, this));
            return;
          }
        }
        this._state = true;
        this._value = newValue;
        finale.call(this);
      } catch (e) {
        reject.call(this, e);
      }
    }
    function reject(newValue) {
      this._state = false;
      this._value = newValue;
      finale.call(this);
    }
    function finale() {
      for (var i = 0, len = this._deferreds.length; i < len; i++) {
        handle.call(this, this._deferreds[i]);
      }
      this._deferreds = null;
    }
    function Handler(onFulfilled, onRejected, resolve, reject) {
      this.onFulfilled = typeof onFulfilled === 'function' ? onFulfilled : null;
      this.onRejected = typeof onRejected === 'function' ? onRejected : null;
      this.resolve = resolve;
      this.reject = reject;
    }
    function doResolve(fn, onFulfilled, onRejected) {
      var done = false;
      try {
        fn(function (value) {
          if (done)
            return;
          done = true;
          onFulfilled(value);
        }, function (reason) {
          if (done)
            return;
          done = true;
          onRejected(reason);
        });
      } catch (ex) {
        if (done)
          return;
        done = true;
        onRejected(ex);
      }
    }
    Promise.prototype['catch'] = function (onRejected) {
      return this.then(null, onRejected);
    };
    Promise.prototype.then = function (onFulfilled, onRejected) {
      var me = this;
      return new Promise(function (resolve, reject) {
        handle.call(me, new Handler(onFulfilled, onRejected, resolve, reject));
      });
    };
    Promise.all = function () {
      var args = Array.prototype.slice.call(arguments.length === 1 && isArray(arguments[0]) ? arguments[0] : arguments);
      return new Promise(function (resolve, reject) {
        if (args.length === 0)
          return resolve([]);
        var remaining = args.length;
        function res(i, val) {
          try {
            if (val && (typeof val === 'object' || typeof val === 'function')) {
              var then = val.then;
              if (typeof then === 'function') {
                then.call(val, function (val) {
                  res(i, val);
                }, reject);
                return;
              }
            }
            args[i] = val;
            if (--remaining === 0) {
              resolve(args);
            }
          } catch (ex) {
            reject(ex);
          }
        }
        for (var i = 0; i < args.length; i++) {
          res(i, args[i]);
        }
      });
    };
    Promise.resolve = function (value) {
      if (value && typeof value === 'object' && value.constructor === Promise) {
        return value;
      }
      return new Promise(function (resolve) {
        resolve(value);
      });
    };
    Promise.reject = function (value) {
      return new Promise(function (resolve, reject) {
        reject(value);
      });
    };
    Promise.race = function (values) {
      return new Promise(function (resolve, reject) {
        for (var i = 0, len = values.length; i < len; i++) {
          values[i].then(resolve, reject);
        }
      });
    };
    return Promise;
  };
  var Promise = window.Promise ? window.Promise : promise();

  var Blob = function (parts, properties) {
    var f = $_dvuzfwwdjcq8ha9k.getOrDie('Blob');
    return new f(parts, properties);
  };

  var FileReader = function () {
    var f = $_dvuzfwwdjcq8ha9k.getOrDie('FileReader');
    return new f();
  };

  var Uint8Array = function (arr) {
    var f = $_dvuzfwwdjcq8ha9k.getOrDie('Uint8Array');
    return new f(arr);
  };

  var requestAnimationFrame = function (callback) {
    var f = $_dvuzfwwdjcq8ha9k.getOrDie('requestAnimationFrame');
    f(callback);
  };
  var atob = function (base64) {
    var f = $_dvuzfwwdjcq8ha9k.getOrDie('atob');
    return f(base64);
  };
  var $_1xvqqv11njcq8hb13 = {
    atob: atob,
    requestAnimationFrame: requestAnimationFrame
  };

  function loadImage(image) {
    return new Promise(function (resolve) {
      function loaded() {
        image.removeEventListener('load', loaded);
        resolve(image);
      }
      if (image.complete) {
        resolve(image);
      } else {
        image.addEventListener('load', loaded);
      }
    });
  }
  function imageToBlob$1(image) {
    return loadImage(image).then(function (image) {
      var src = image.src;
      if (src.indexOf('blob:') === 0) {
        return anyUriToBlob(src);
      }
      if (src.indexOf('data:') === 0) {
        return dataUriToBlob(src);
      }
      return anyUriToBlob(src);
    });
  }
  function blobToImage$1(blob) {
    return new Promise(function (resolve, reject) {
      var blobUrl = URL.createObjectURL(blob);
      var image = new Image();
      var removeListeners = function () {
        image.removeEventListener('load', loaded);
        image.removeEventListener('error', error);
      };
      function loaded() {
        removeListeners();
        resolve(image);
      }
      function error() {
        removeListeners();
        reject('Unable to load data of type ' + blob.type + ': ' + blobUrl);
      }
      image.addEventListener('load', loaded);
      image.addEventListener('error', error);
      image.src = blobUrl;
      if (image.complete) {
        loaded();
      }
    });
  }
  function anyUriToBlob(url) {
    return new Promise(function (resolve) {
      var xhr = new XMLHttpRequest();
      xhr.open('GET', url, true);
      xhr.responseType = 'blob';
      xhr.onload = function () {
        if (this.status == 200) {
          resolve(this.response);
        }
      };
      xhr.send();
    });
  }
  function dataUriToBlobSync$1(uri) {
    var data = uri.split(',');
    var matches = /data:([^;]+)/.exec(data[0]);
    if (!matches)
      return $_9m6n87wajcq8ha9e.none();
    var mimetype = matches[1];
    var base64 = data[1];
    var sliceSize = 1024;
    var byteCharacters = $_1xvqqv11njcq8hb13.atob(base64);
    var bytesLength = byteCharacters.length;
    var slicesCount = Math.ceil(bytesLength / sliceSize);
    var byteArrays = new Array(slicesCount);
    for (var sliceIndex = 0; sliceIndex < slicesCount; ++sliceIndex) {
      var begin = sliceIndex * sliceSize;
      var end = Math.min(begin + sliceSize, bytesLength);
      var bytes = new Array(end - begin);
      for (var offset = begin, i = 0; offset < end; ++i, ++offset) {
        bytes[i] = byteCharacters[offset].charCodeAt(0);
      }
      byteArrays[sliceIndex] = Uint8Array(bytes);
    }
    return $_9m6n87wajcq8ha9e.some(Blob(byteArrays, { type: mimetype }));
  }
  function dataUriToBlob(uri) {
    return new Promise(function (resolve, reject) {
      dataUriToBlobSync$1(uri).fold(function () {
        reject('uri is not base64: ' + uri);
      }, resolve);
    });
  }
  function uriToBlob$1(url) {
    if (url.indexOf('blob:') === 0) {
      return anyUriToBlob(url);
    }
    if (url.indexOf('data:') === 0) {
      return dataUriToBlob(url);
    }
    return null;
  }
  function canvasToBlob(canvas, type, quality) {
    type = type || 'image/png';
    if (HTMLCanvasElement.prototype.toBlob) {
      return new Promise(function (resolve) {
        canvas.toBlob(function (blob) {
          resolve(blob);
        }, type, quality);
      });
    } else {
      return dataUriToBlob(canvas.toDataURL(type, quality));
    }
  }
  function canvasToDataURL(getCanvas, type, quality) {
    type = type || 'image/png';
    return getCanvas.then(function (canvas) {
      return canvas.toDataURL(type, quality);
    });
  }
  function blobToCanvas(blob) {
    return blobToImage$1(blob).then(function (image) {
      revokeImageUrl(image);
      var context, canvas;
      canvas = $_dgg38111hjcq8hb0u.create($_fstwbk11ijcq8hb0v.getWidth(image), $_fstwbk11ijcq8hb0v.getHeight(image));
      context = $_dgg38111hjcq8hb0u.get2dContext(canvas);
      context.drawImage(image, 0, 0);
      return canvas;
    });
  }
  function blobToDataUri$1(blob) {
    return new Promise(function (resolve) {
      var reader = new FileReader();
      reader.onloadend = function () {
        resolve(reader.result);
      };
      reader.readAsDataURL(blob);
    });
  }
  function blobToBase64$1(blob) {
    return blobToDataUri$1(blob).then(function (dataUri) {
      return dataUri.split(',')[1];
    });
  }
  function revokeImageUrl(image) {
    URL.revokeObjectURL(image.src);
  }
  var $_f235oh11gjcq8hb0f = {
    blobToImage: blobToImage$1,
    imageToBlob: imageToBlob$1,
    blobToDataUri: blobToDataUri$1,
    blobToBase64: blobToBase64$1,
    dataUriToBlobSync: dataUriToBlobSync$1,
    canvasToBlob: canvasToBlob,
    canvasToDataURL: canvasToDataURL,
    blobToCanvas: blobToCanvas,
    uriToBlob: uriToBlob$1
  };

  var blobToImage = function (image) {
    return $_f235oh11gjcq8hb0f.blobToImage(image);
  };
  var imageToBlob = function (blob) {
    return $_f235oh11gjcq8hb0f.imageToBlob(blob);
  };
  var blobToDataUri = function (blob) {
    return $_f235oh11gjcq8hb0f.blobToDataUri(blob);
  };
  var blobToBase64 = function (blob) {
    return $_f235oh11gjcq8hb0f.blobToBase64(blob);
  };
  var dataUriToBlobSync = function (uri) {
    return $_f235oh11gjcq8hb0f.dataUriToBlobSync(uri);
  };
  var uriToBlob = function (uri) {
    return $_9m6n87wajcq8ha9e.from($_f235oh11gjcq8hb0f.uriToBlob(uri));
  };
  var $_83twoj11fjcq8hb0c = {
    blobToImage: blobToImage,
    imageToBlob: imageToBlob,
    blobToDataUri: blobToDataUri,
    blobToBase64: blobToBase64,
    dataUriToBlobSync: dataUriToBlobSync,
    uriToBlob: uriToBlob
  };

  var addImage = function (editor, blob) {
    $_83twoj11fjcq8hb0c.blobToBase64(blob).then(function (base64) {
      editor.undoManager.transact(function () {
        var cache = editor.editorUpload.blobCache;
        var info = cache.create($_8zlm8d10gjcq8hauo.generate('mceu'), blob, base64);
        cache.add(info);
        var img = editor.dom.createHTML('img', { src: info.blobUri() });
        editor.insertContent(img);
      });
    });
  };
  var extractBlob = function (simulatedEvent) {
    var event = simulatedEvent.event();
    var files = event.raw().target.files || event.raw().dataTransfer.files;
    return $_9m6n87wajcq8ha9e.from(files[0]);
  };
  var sketch$5 = function (editor) {
    var pickerDom = {
      tag: 'input',
      attributes: {
        accept: 'image/*',
        type: 'file',
        title: ''
      },
      styles: {
        visibility: 'hidden',
        position: 'absolute'
      }
    };
    var memPicker = $_4sw8ie11ejcq8hb07.record({
      dom: pickerDom,
      events: $_dkbc99w6jcq8ha8p.derive([
        $_dkbc99w6jcq8ha8p.cutter($_gcr2umwxjcq8hab1.click()),
        $_dkbc99w6jcq8ha8p.run($_gcr2umwxjcq8hab1.change(), function (picker, simulatedEvent) {
          extractBlob(simulatedEvent).each(function (blob) {
            addImage(editor, blob);
          });
        })
      ])
    });
    return Button.sketch({
      dom: $_21mxhc10qjcq8hawt.dom('<span class="${prefix}-toolbar-button ${prefix}-icon-image ${prefix}-icon"></span>'),
      components: [memPicker.asSpec()],
      action: function (button) {
        var picker = memPicker.get(button);
        picker.element().dom().click();
      }
    });
  };
  var $_qik9711djcq8hazz = { sketch: sketch$5 };

  var get$8 = function (element) {
    return element.dom().textContent;
  };
  var set$5 = function (element, value) {
    element.dom().textContent = value;
  };
  var $_cexyr711qjcq8hb1g = {
    get: get$8,
    set: set$5
  };

  var isNotEmpty = function (val) {
    return val.length > 0;
  };
  var defaultToEmpty = function (str) {
    return str === undefined || str === null ? '' : str;
  };
  var noLink = function (editor) {
    var text = editor.selection.getContent({ format: 'text' });
    return {
      url: '',
      text: text,
      title: '',
      target: '',
      link: $_9m6n87wajcq8ha9e.none()
    };
  };
  var fromLink = function (link) {
    var text = $_cexyr711qjcq8hb1g.get(link);
    var url = $_3kyqh4xwjcq8hajw.get(link, 'href');
    var title = $_3kyqh4xwjcq8hajw.get(link, 'title');
    var target = $_3kyqh4xwjcq8hajw.get(link, 'target');
    return {
      url: defaultToEmpty(url),
      text: text !== url ? defaultToEmpty(text) : '',
      title: defaultToEmpty(title),
      target: defaultToEmpty(target),
      link: $_9m6n87wajcq8ha9e.some(link)
    };
  };
  var getInfo = function (editor) {
    return query(editor).fold(function () {
      return noLink(editor);
    }, function (link) {
      return fromLink(link);
    });
  };
  var wasSimple = function (link) {
    var prevHref = $_3kyqh4xwjcq8hajw.get(link, 'href');
    var prevText = $_cexyr711qjcq8hb1g.get(link);
    return prevHref === prevText;
  };
  var getTextToApply = function (link, url, info) {
    return info.text.filter(isNotEmpty).fold(function () {
      return wasSimple(link) ? $_9m6n87wajcq8ha9e.some(url) : $_9m6n87wajcq8ha9e.none();
    }, $_9m6n87wajcq8ha9e.some);
  };
  var unlinkIfRequired = function (editor, info) {
    var activeLink = info.link.bind($_dh3z58wbjcq8ha9h.identity);
    activeLink.each(function (link) {
      editor.execCommand('unlink');
    });
  };
  var getAttrs$1 = function (url, info) {
    var attrs = {};
    attrs.href = url;
    info.title.filter(isNotEmpty).each(function (title) {
      attrs.title = title;
    });
    info.target.filter(isNotEmpty).each(function (target) {
      attrs.target = target;
    });
    return attrs;
  };
  var applyInfo = function (editor, info) {
    info.url.filter(isNotEmpty).fold(function () {
      unlinkIfRequired(editor, info);
    }, function (url) {
      var attrs = getAttrs$1(url, info);
      var activeLink = info.link.bind($_dh3z58wbjcq8ha9h.identity);
      activeLink.fold(function () {
        var text = info.text.filter(isNotEmpty).getOr(url);
        editor.insertContent(editor.dom.createHTML('a', attrs, editor.dom.encode(text)));
      }, function (link) {
        var text = getTextToApply(link, url, info);
        $_3kyqh4xwjcq8hajw.setAll(link, attrs);
        text.each(function (newText) {
          $_cexyr711qjcq8hb1g.set(link, newText);
        });
      });
    });
  };
  var query = function (editor) {
    var start = $_1t8d5wwtjcq8haao.fromDom(editor.selection.getStart());
    return $_9rnmwhzmjcq8haqn.closest(start, 'a');
  };
  var $_ama0h311pjcq8hb19 = {
    getInfo: getInfo,
    applyInfo: applyInfo,
    query: query
  };

  var events$6 = function (name, eventHandlers) {
    var events = $_dkbc99w6jcq8ha8p.derive(eventHandlers);
    return $_bfiithw4jcq8ha84.create({
      fields: [$_ah67nix2jcq8habi.strict('enabled')],
      name: name,
      active: { events: $_dh3z58wbjcq8ha9h.constant(events) }
    });
  };
  var config = function (name, eventHandlers) {
    var me = events$6(name, eventHandlers);
    return {
      key: name,
      value: {
        config: {},
        me: me,
        configAsRaw: $_dh3z58wbjcq8ha9h.constant({}),
        initialConfig: {},
        state: $_bfiithw4jcq8ha84.noState()
      }
    };
  };
  var $_f3aums11sjcq8hb1v = {
    events: events$6,
    config: config
  };

  var getCurrent = function (component, composeConfig, composeState) {
    return composeConfig.find()(component);
  };
  var $_3pziyi11ujcq8hb1z = { getCurrent: getCurrent };

  var ComposeSchema = [$_ah67nix2jcq8habi.strict('find')];

  var Composing = $_bfiithw4jcq8ha84.create({
    fields: ComposeSchema,
    name: 'composing',
    apis: $_3pziyi11ujcq8hb1z
  });

  var factory$1 = function (detail, spec) {
    return {
      uid: detail.uid(),
      dom: $_936c00wyjcq8hab3.deepMerge({
        tag: 'div',
        attributes: { role: 'presentation' }
      }, detail.dom()),
      components: detail.components(),
      behaviours: $_b4pjyg10djcq8hau7.get(detail.containerBehaviours()),
      events: detail.events(),
      domModification: detail.domModification(),
      eventOrder: detail.eventOrder()
    };
  };
  var Container = $_cocv7l10ejcq8hauc.single({
    name: 'Container',
    factory: factory$1,
    configFields: [
      $_ah67nix2jcq8habi.defaulted('components', []),
      $_b4pjyg10djcq8hau7.field('containerBehaviours', []),
      $_ah67nix2jcq8habi.defaulted('events', {}),
      $_ah67nix2jcq8habi.defaulted('domModification', {}),
      $_ah67nix2jcq8habi.defaulted('eventOrder', {})
    ]
  });

  var factory$2 = function (detail, spec) {
    return {
      uid: detail.uid(),
      dom: detail.dom(),
      behaviours: $_936c00wyjcq8hab3.deepMerge($_bfiithw4jcq8ha84.derive([
        me.config({
          store: {
            mode: 'memory',
            initialValue: detail.getInitialValue()()
          }
        }),
        Composing.config({ find: $_9m6n87wajcq8ha9e.some })
      ]), $_b4pjyg10djcq8hau7.get(detail.dataBehaviours())),
      events: $_dkbc99w6jcq8ha8p.derive([$_dkbc99w6jcq8ha8p.runOnAttached(function (component, simulatedEvent) {
          me.setValue(component, detail.getInitialValue()());
        })])
    };
  };
  var DataField = $_cocv7l10ejcq8hauc.single({
    name: 'DataField',
    factory: factory$2,
    configFields: [
      $_ah67nix2jcq8habi.strict('uid'),
      $_ah67nix2jcq8habi.strict('dom'),
      $_ah67nix2jcq8habi.strict('getInitialValue'),
      $_b4pjyg10djcq8hau7.field('dataBehaviours', [
        me,
        Composing
      ])
    ]
  });

  var get$9 = function (element) {
    return element.dom().value;
  };
  var set$6 = function (element, value) {
    if (value === undefined)
      throw new Error('Value.set was undefined');
    element.dom().value = value;
  };
  var $_eixe2b120jcq8hb2r = {
    set: set$6,
    get: get$9
  };

  var schema$8 = [
    $_ah67nix2jcq8habi.option('data'),
    $_ah67nix2jcq8habi.defaulted('inputAttributes', {}),
    $_ah67nix2jcq8habi.defaulted('inputStyles', {}),
    $_ah67nix2jcq8habi.defaulted('type', 'input'),
    $_ah67nix2jcq8habi.defaulted('tag', 'input'),
    $_ah67nix2jcq8habi.defaulted('inputClasses', []),
    $_fvpuwdytjcq8hanb.onHandler('onSetValue'),
    $_ah67nix2jcq8habi.defaulted('styles', {}),
    $_ah67nix2jcq8habi.option('placeholder'),
    $_ah67nix2jcq8habi.defaulted('eventOrder', {}),
    $_b4pjyg10djcq8hau7.field('inputBehaviours', [
      me,
      Focusing
    ]),
    $_ah67nix2jcq8habi.defaulted('selectOnFocus', true)
  ];
  var behaviours = function (detail) {
    return $_936c00wyjcq8hab3.deepMerge($_bfiithw4jcq8ha84.derive([
      me.config({
        store: {
          mode: 'manual',
          initialValue: detail.data().getOr(undefined),
          getValue: function (input) {
            return $_eixe2b120jcq8hb2r.get(input.element());
          },
          setValue: function (input, data) {
            var current = $_eixe2b120jcq8hb2r.get(input.element());
            if (current !== data) {
              $_eixe2b120jcq8hb2r.set(input.element(), data);
            }
          }
        },
        onSetValue: detail.onSetValue()
      }),
      Focusing.config({
        onFocus: detail.selectOnFocus() === false ? $_dh3z58wbjcq8ha9h.noop : function (component) {
          var input = component.element();
          var value = $_eixe2b120jcq8hb2r.get(input);
          input.dom().setSelectionRange(0, value.length);
        }
      })
    ]), $_b4pjyg10djcq8hau7.get(detail.inputBehaviours()));
  };
  var dom$2 = function (detail) {
    return {
      tag: detail.tag(),
      attributes: $_936c00wyjcq8hab3.deepMerge($_f2tmkex6jcq8hach.wrapAll([{
          key: 'type',
          value: detail.type()
        }].concat(detail.placeholder().map(function (pc) {
        return {
          key: 'placeholder',
          value: pc
        };
      }).toArray())), detail.inputAttributes()),
      styles: detail.inputStyles(),
      classes: detail.inputClasses()
    };
  };
  var $_6h6v0711zjcq8hb2d = {
    schema: $_dh3z58wbjcq8ha9h.constant(schema$8),
    behaviours: behaviours,
    dom: dom$2
  };

  var factory$3 = function (detail, spec) {
    return {
      uid: detail.uid(),
      dom: $_6h6v0711zjcq8hb2d.dom(detail),
      components: [],
      behaviours: $_6h6v0711zjcq8hb2d.behaviours(detail),
      eventOrder: detail.eventOrder()
    };
  };
  var Input = $_cocv7l10ejcq8hauc.single({
    name: 'Input',
    configFields: $_6h6v0711zjcq8hb2d.schema(),
    factory: factory$3
  });

  var exhibit$3 = function (base, tabConfig) {
    return $_720ux0xkjcq8haj2.nu({
      attributes: $_f2tmkex6jcq8hach.wrapAll([{
          key: tabConfig.tabAttr(),
          value: 'true'
        }])
    });
  };
  var $_e8bgyw122jcq8hb2u = { exhibit: exhibit$3 };

  var TabstopSchema = [$_ah67nix2jcq8habi.defaulted('tabAttr', 'data-alloy-tabstop')];

  var Tabstopping = $_bfiithw4jcq8ha84.create({
    fields: TabstopSchema,
    name: 'tabstopping',
    active: $_e8bgyw122jcq8hb2u
  });

  var clearInputBehaviour = 'input-clearing';
  var field$2 = function (name, placeholder) {
    var inputSpec = $_4sw8ie11ejcq8hb07.record(Input.sketch({
      placeholder: placeholder,
      onSetValue: function (input, data) {
        $_3yqf3awvjcq8haat.emit(input, $_gcr2umwxjcq8hab1.input());
      },
      inputBehaviours: $_bfiithw4jcq8ha84.derive([
        Composing.config({ find: $_9m6n87wajcq8ha9e.some }),
        Tabstopping.config({}),
        Keying.config({ mode: 'execution' })
      ]),
      selectOnFocus: false
    }));
    var buttonSpec = $_4sw8ie11ejcq8hb07.record(Button.sketch({
      dom: $_21mxhc10qjcq8hawt.dom('<button class="${prefix}-input-container-x ${prefix}-icon-cancel-circle ${prefix}-icon"></button>'),
      action: function (button) {
        var input = inputSpec.get(button);
        me.setValue(input, '');
      }
    }));
    return {
      name: name,
      spec: Container.sketch({
        dom: $_21mxhc10qjcq8hawt.dom('<div class="${prefix}-input-container"></div>'),
        components: [
          inputSpec.asSpec(),
          buttonSpec.asSpec()
        ],
        containerBehaviours: $_bfiithw4jcq8ha84.derive([
          Toggling.config({ toggleClass: $_30duqlz1jcq8haoh.resolve('input-container-empty') }),
          Composing.config({
            find: function (comp) {
              return $_9m6n87wajcq8ha9e.some(inputSpec.get(comp));
            }
          }),
          $_f3aums11sjcq8hb1v.config(clearInputBehaviour, [$_dkbc99w6jcq8ha8p.run($_gcr2umwxjcq8hab1.input(), function (iContainer) {
              var input = inputSpec.get(iContainer);
              var val = me.getValue(input);
              var f = val.length > 0 ? Toggling.off : Toggling.on;
              f(iContainer);
            })])
        ])
      })
    };
  };
  var hidden = function (name) {
    return {
      name: name,
      spec: DataField.sketch({
        dom: {
          tag: 'span',
          styles: { display: 'none' }
        },
        getInitialValue: function () {
          return $_9m6n87wajcq8ha9e.none();
        }
      })
    };
  };
  var $_4vo79m11rjcq8hb1h = {
    field: field$2,
    hidden: hidden
  };

  var nativeDisabled = [
    'input',
    'button',
    'textarea'
  ];
  var onLoad$5 = function (component, disableConfig, disableState) {
    if (disableConfig.disabled())
      disable(component, disableConfig, disableState);
  };
  var hasNative = function (component) {
    return $_dojsh2w9jcq8ha93.contains(nativeDisabled, $_4z03v7xxjcq8hak1.name(component.element()));
  };
  var nativeIsDisabled = function (component) {
    return $_3kyqh4xwjcq8hajw.has(component.element(), 'disabled');
  };
  var nativeDisable = function (component) {
    $_3kyqh4xwjcq8hajw.set(component.element(), 'disabled', 'disabled');
  };
  var nativeEnable = function (component) {
    $_3kyqh4xwjcq8hajw.remove(component.element(), 'disabled');
  };
  var ariaIsDisabled = function (component) {
    return $_3kyqh4xwjcq8hajw.get(component.element(), 'aria-disabled') === 'true';
  };
  var ariaDisable = function (component) {
    $_3kyqh4xwjcq8hajw.set(component.element(), 'aria-disabled', 'true');
  };
  var ariaEnable = function (component) {
    $_3kyqh4xwjcq8hajw.set(component.element(), 'aria-disabled', 'false');
  };
  var disable = function (component, disableConfig, disableState) {
    disableConfig.disableClass().each(function (disableClass) {
      $_waygfxujcq8hajt.add(component.element(), disableClass);
    });
    var f = hasNative(component) ? nativeDisable : ariaDisable;
    f(component);
  };
  var enable = function (component, disableConfig, disableState) {
    disableConfig.disableClass().each(function (disableClass) {
      $_waygfxujcq8hajt.remove(component.element(), disableClass);
    });
    var f = hasNative(component) ? nativeEnable : ariaEnable;
    f(component);
  };
  var isDisabled = function (component) {
    return hasNative(component) ? nativeIsDisabled(component) : ariaIsDisabled(component);
  };
  var $_dkp9kg127jcq8hb3o = {
    enable: enable,
    disable: disable,
    isDisabled: isDisabled,
    onLoad: onLoad$5
  };

  var exhibit$4 = function (base, disableConfig, disableState) {
    return $_720ux0xkjcq8haj2.nu({ classes: disableConfig.disabled() ? disableConfig.disableClass().map($_dojsh2w9jcq8ha93.pure).getOr([]) : [] });
  };
  var events$7 = function (disableConfig, disableState) {
    return $_dkbc99w6jcq8ha8p.derive([
      $_dkbc99w6jcq8ha8p.abort($_51ilu1wwjcq8haax.execute(), function (component, simulatedEvent) {
        return $_dkp9kg127jcq8hb3o.isDisabled(component, disableConfig, disableState);
      }),
      $_1oalwmw5jcq8ha8c.loadEvent(disableConfig, disableState, $_dkp9kg127jcq8hb3o.onLoad)
    ]);
  };
  var $_6qoubs126jcq8hb3m = {
    exhibit: exhibit$4,
    events: events$7
  };

  var DisableSchema = [
    $_ah67nix2jcq8habi.defaulted('disabled', false),
    $_ah67nix2jcq8habi.option('disableClass')
  ];

  var Disabling = $_bfiithw4jcq8ha84.create({
    fields: DisableSchema,
    name: 'disabling',
    active: $_6qoubs126jcq8hb3m,
    apis: $_dkp9kg127jcq8hb3o
  });

  var owner$1 = 'form';
  var schema$9 = [$_b4pjyg10djcq8hau7.field('formBehaviours', [me])];
  var getPartName = function (name) {
    return '<alloy.field.' + name + '>';
  };
  var sketch$8 = function (fSpec) {
    var parts = function () {
      var record = [];
      var field = function (name, config) {
        record.push(name);
        return $_70h8qs10ijcq8haut.generateOne(owner$1, getPartName(name), config);
      };
      return {
        field: field,
        record: function () {
          return record;
        }
      };
    }();
    var spec = fSpec(parts);
    var partNames = parts.record();
    var fieldParts = $_dojsh2w9jcq8ha93.map(partNames, function (n) {
      return $_50i5hr10kjcq8havc.required({
        name: n,
        pname: getPartName(n)
      });
    });
    return $_einy8o10hjcq8haup.composite(owner$1, schema$9, fieldParts, make, spec);
  };
  var make = function (detail, components, spec) {
    return $_936c00wyjcq8hab3.deepMerge({
      'debug.sketcher': { 'Form': spec },
      uid: detail.uid(),
      dom: detail.dom(),
      components: components,
      behaviours: $_936c00wyjcq8hab3.deepMerge($_bfiithw4jcq8ha84.derive([me.config({
          store: {
            mode: 'manual',
            getValue: function (form) {
              var optPs = $_70h8qs10ijcq8haut.getAllParts(form, detail);
              return $_et458cx0jcq8hab6.map(optPs, function (optPThunk, pName) {
                return optPThunk().bind(Composing.getCurrent).map(me.getValue);
              });
            },
            setValue: function (form, values) {
              $_et458cx0jcq8hab6.each(values, function (newValue, key) {
                $_70h8qs10ijcq8haut.getPart(form, detail, key).each(function (wrapper) {
                  Composing.getCurrent(wrapper).each(function (field) {
                    me.setValue(field, newValue);
                  });
                });
              });
            }
          }
        })]), $_b4pjyg10djcq8hau7.get(detail.formBehaviours())),
      apis: {
        getField: function (form, key) {
          return $_70h8qs10ijcq8haut.getPart(form, detail, key).bind(Composing.getCurrent);
        }
      }
    });
  };
  var $_a0pksi129jcq8hb3y = {
    getField: $_edxw3210fjcq8hauj.makeApi(function (apis, component, key) {
      return apis.getField(component, key);
    }),
    sketch: sketch$8
  };

  var revocable = function (doRevoke) {
    var subject = Cell($_9m6n87wajcq8ha9e.none());
    var revoke = function () {
      subject.get().each(doRevoke);
    };
    var clear = function () {
      revoke();
      subject.set($_9m6n87wajcq8ha9e.none());
    };
    var set = function (s) {
      revoke();
      subject.set($_9m6n87wajcq8ha9e.some(s));
    };
    var isSet = function () {
      return subject.get().isSome();
    };
    return {
      clear: clear,
      isSet: isSet,
      set: set
    };
  };
  var destroyable = function () {
    return revocable(function (s) {
      s.destroy();
    });
  };
  var unbindable = function () {
    return revocable(function (s) {
      s.unbind();
    });
  };
  var api$2 = function () {
    var subject = Cell($_9m6n87wajcq8ha9e.none());
    var revoke = function () {
      subject.get().each(function (s) {
        s.destroy();
      });
    };
    var clear = function () {
      revoke();
      subject.set($_9m6n87wajcq8ha9e.none());
    };
    var set = function (s) {
      revoke();
      subject.set($_9m6n87wajcq8ha9e.some(s));
    };
    var run = function (f) {
      subject.get().each(f);
    };
    var isSet = function () {
      return subject.get().isSome();
    };
    return {
      clear: clear,
      isSet: isSet,
      set: set,
      run: run
    };
  };
  var value$3 = function () {
    var subject = Cell($_9m6n87wajcq8ha9e.none());
    var clear = function () {
      subject.set($_9m6n87wajcq8ha9e.none());
    };
    var set = function (s) {
      subject.set($_9m6n87wajcq8ha9e.some(s));
    };
    var on = function (f) {
      subject.get().each(f);
    };
    var isSet = function () {
      return subject.get().isSome();
    };
    return {
      clear: clear,
      set: set,
      isSet: isSet,
      on: on
    };
  };
  var $_ffeym512ajcq8hb4a = {
    destroyable: destroyable,
    unbindable: unbindable,
    api: api$2,
    value: value$3
  };

  var SWIPING_LEFT = 1;
  var SWIPING_RIGHT = -1;
  var SWIPING_NONE = 0;
  var init$3 = function (xValue) {
    return {
      xValue: xValue,
      points: []
    };
  };
  var move = function (model, xValue) {
    if (xValue === model.xValue) {
      return model;
    }
    var currentDirection = xValue - model.xValue > 0 ? SWIPING_LEFT : SWIPING_RIGHT;
    var newPoint = {
      direction: currentDirection,
      xValue: xValue
    };
    var priorPoints = function () {
      if (model.points.length === 0) {
        return [];
      } else {
        var prev = model.points[model.points.length - 1];
        return prev.direction === currentDirection ? model.points.slice(0, model.points.length - 1) : model.points;
      }
    }();
    return {
      xValue: xValue,
      points: priorPoints.concat([newPoint])
    };
  };
  var complete = function (model) {
    if (model.points.length === 0) {
      return SWIPING_NONE;
    } else {
      var firstDirection = model.points[0].direction;
      var lastDirection = model.points[model.points.length - 1].direction;
      return firstDirection === SWIPING_RIGHT && lastDirection === SWIPING_RIGHT ? SWIPING_RIGHT : firstDirection === SWIPING_LEFT && lastDirection === SWIPING_LEFT ? SWIPING_LEFT : SWIPING_NONE;
    }
  };
  var $_8b435y12bjcq8hb4d = {
    init: init$3,
    move: move,
    complete: complete
  };

  var sketch$7 = function (rawSpec) {
    var navigateEvent = 'navigateEvent';
    var wrapperAdhocEvents = 'serializer-wrapper-events';
    var formAdhocEvents = 'form-events';
    var schema = $_g540acxhjcq8hadd.objOf([
      $_ah67nix2jcq8habi.strict('fields'),
      $_ah67nix2jcq8habi.defaulted('maxFieldIndex', rawSpec.fields.length - 1),
      $_ah67nix2jcq8habi.strict('onExecute'),
      $_ah67nix2jcq8habi.strict('getInitialValue'),
      $_ah67nix2jcq8habi.state('state', function () {
        return {
          dialogSwipeState: $_ffeym512ajcq8hb4a.value(),
          currentScreen: Cell(0)
        };
      })
    ]);
    var spec = $_g540acxhjcq8hadd.asRawOrDie('SerialisedDialog', schema, rawSpec);
    var navigationButton = function (direction, directionName, enabled) {
      return Button.sketch({
        dom: $_21mxhc10qjcq8hawt.dom('<span class="${prefix}-icon-' + directionName + ' ${prefix}-icon"></span>'),
        action: function (button) {
          $_3yqf3awvjcq8haat.emitWith(button, navigateEvent, { direction: direction });
        },
        buttonBehaviours: $_bfiithw4jcq8ha84.derive([Disabling.config({
            disableClass: $_30duqlz1jcq8haoh.resolve('toolbar-navigation-disabled'),
            disabled: !enabled
          })])
      });
    };
    var reposition = function (dialog, message) {
      $_9rnmwhzmjcq8haqn.descendant(dialog.element(), '.' + $_30duqlz1jcq8haoh.resolve('serialised-dialog-chain')).each(function (parent) {
        $_bljwzsjcq8har2.set(parent, 'left', -spec.state.currentScreen.get() * message.width + 'px');
      });
    };
    var navigate = function (dialog, direction) {
      var screens = $_9rnqqqzkjcq8haqj.descendants(dialog.element(), '.' + $_30duqlz1jcq8haoh.resolve('serialised-dialog-screen'));
      $_9rnmwhzmjcq8haqn.descendant(dialog.element(), '.' + $_30duqlz1jcq8haoh.resolve('serialised-dialog-chain')).each(function (parent) {
        if (spec.state.currentScreen.get() + direction >= 0 && spec.state.currentScreen.get() + direction < screens.length) {
          $_bljwzsjcq8har2.getRaw(parent, 'left').each(function (left) {
            var currentLeft = parseInt(left, 10);
            var w = $_72au9u117jcq8hazb.get(screens[0]);
            $_bljwzsjcq8har2.set(parent, 'left', currentLeft - direction * w + 'px');
          });
          spec.state.currentScreen.set(spec.state.currentScreen.get() + direction);
        }
      });
    };
    var focusInput = function (dialog) {
      var inputs = $_9rnqqqzkjcq8haqj.descendants(dialog.element(), 'input');
      var optInput = $_9m6n87wajcq8ha9e.from(inputs[spec.state.currentScreen.get()]);
      optInput.each(function (input) {
        dialog.getSystem().getByDom(input).each(function (inputComp) {
          $_3yqf3awvjcq8haat.dispatchFocus(dialog, inputComp.element());
        });
      });
      var dotitems = memDots.get(dialog);
      Highlighting.highlightAt(dotitems, spec.state.currentScreen.get());
    };
    var resetState = function () {
      spec.state.currentScreen.set(0);
      spec.state.dialogSwipeState.clear();
    };
    var memForm = $_4sw8ie11ejcq8hb07.record($_a0pksi129jcq8hb3y.sketch(function (parts) {
      return {
        dom: $_21mxhc10qjcq8hawt.dom('<div class="${prefix}-serialised-dialog"></div>'),
        components: [Container.sketch({
            dom: $_21mxhc10qjcq8hawt.dom('<div class="${prefix}-serialised-dialog-chain" style="left: 0px; position: absolute;"></div>'),
            components: $_dojsh2w9jcq8ha93.map(spec.fields, function (field, i) {
              return i <= spec.maxFieldIndex ? Container.sketch({
                dom: $_21mxhc10qjcq8hawt.dom('<div class="${prefix}-serialised-dialog-screen"></div>'),
                components: $_dojsh2w9jcq8ha93.flatten([
                  [navigationButton(-1, 'previous', i > 0)],
                  [parts.field(field.name, field.spec)],
                  [navigationButton(+1, 'next', i < spec.maxFieldIndex)]
                ])
              }) : parts.field(field.name, field.spec);
            })
          })],
        formBehaviours: $_bfiithw4jcq8ha84.derive([
          $_dnir0tz0jcq8hao8.orientation(function (dialog, message) {
            reposition(dialog, message);
          }),
          Keying.config({
            mode: 'special',
            focusIn: function (dialog) {
              focusInput(dialog);
            },
            onTab: function (dialog) {
              navigate(dialog, +1);
              return $_9m6n87wajcq8ha9e.some(true);
            },
            onShiftTab: function (dialog) {
              navigate(dialog, -1);
              return $_9m6n87wajcq8ha9e.some(true);
            }
          }),
          $_f3aums11sjcq8hb1v.config(formAdhocEvents, [
            $_dkbc99w6jcq8ha8p.runOnAttached(function (dialog, simulatedEvent) {
              resetState();
              var dotitems = memDots.get(dialog);
              Highlighting.highlightFirst(dotitems);
              spec.getInitialValue(dialog).each(function (v) {
                me.setValue(dialog, v);
              });
            }),
            $_dkbc99w6jcq8ha8p.runOnExecute(spec.onExecute),
            $_dkbc99w6jcq8ha8p.run($_gcr2umwxjcq8hab1.transitionend(), function (dialog, simulatedEvent) {
              if (simulatedEvent.event().raw().propertyName === 'left') {
                focusInput(dialog);
              }
            }),
            $_dkbc99w6jcq8ha8p.run(navigateEvent, function (dialog, simulatedEvent) {
              var direction = simulatedEvent.event().direction();
              navigate(dialog, direction);
            })
          ])
        ])
      };
    }));
    var memDots = $_4sw8ie11ejcq8hb07.record({
      dom: $_21mxhc10qjcq8hawt.dom('<div class="${prefix}-dot-container"></div>'),
      behaviours: $_bfiithw4jcq8ha84.derive([Highlighting.config({
          highlightClass: $_30duqlz1jcq8haoh.resolve('dot-active'),
          itemClass: $_30duqlz1jcq8haoh.resolve('dot-item')
        })]),
      components: $_dojsh2w9jcq8ha93.bind(spec.fields, function (_f, i) {
        return i <= spec.maxFieldIndex ? [$_21mxhc10qjcq8hawt.spec('<div class="${prefix}-dot-item ${prefix}-icon-full-dot ${prefix}-icon"></div>')] : [];
      })
    });
    return {
      dom: $_21mxhc10qjcq8hawt.dom('<div class="${prefix}-serializer-wrapper"></div>'),
      components: [
        memForm.asSpec(),
        memDots.asSpec()
      ],
      behaviours: $_bfiithw4jcq8ha84.derive([
        Keying.config({
          mode: 'special',
          focusIn: function (wrapper) {
            var form = memForm.get(wrapper);
            Keying.focusIn(form);
          }
        }),
        $_f3aums11sjcq8hb1v.config(wrapperAdhocEvents, [
          $_dkbc99w6jcq8ha8p.run($_gcr2umwxjcq8hab1.touchstart(), function (wrapper, simulatedEvent) {
            spec.state.dialogSwipeState.set($_8b435y12bjcq8hb4d.init(simulatedEvent.event().raw().touches[0].clientX));
          }),
          $_dkbc99w6jcq8ha8p.run($_gcr2umwxjcq8hab1.touchmove(), function (wrapper, simulatedEvent) {
            spec.state.dialogSwipeState.on(function (state) {
              simulatedEvent.event().prevent();
              spec.state.dialogSwipeState.set($_8b435y12bjcq8hb4d.move(state, simulatedEvent.event().raw().touches[0].clientX));
            });
          }),
          $_dkbc99w6jcq8ha8p.run($_gcr2umwxjcq8hab1.touchend(), function (wrapper) {
            spec.state.dialogSwipeState.on(function (state) {
              var dialog = memForm.get(wrapper);
              var direction = -1 * $_8b435y12bjcq8hb4d.complete(state);
              navigate(dialog, direction);
            });
          })
        ])
      ])
    };
  };
  var $_bdbqrq124jcq8hb30 = { sketch: sketch$7 };

  var platform$1 = $_6a5cn8wgjcq8ha9o.detect();
  var preserve$1 = function (f, editor) {
    var rng = editor.selection.getRng();
    f();
    editor.selection.setRng(rng);
  };
  var forAndroid = function (editor, f) {
    var wrapper = platform$1.os.isAndroid() ? preserve$1 : $_dh3z58wbjcq8ha9h.apply;
    wrapper(f, editor);
  };
  var $_8r1bu812cjcq8hb4f = { forAndroid: forAndroid };

  var getGroups = $_8mt73whjcq8ha9q.cached(function (realm, editor) {
    return [{
        label: 'the link group',
        items: [$_bdbqrq124jcq8hb30.sketch({
            fields: [
              $_4vo79m11rjcq8hb1h.field('url', 'Type or paste URL'),
              $_4vo79m11rjcq8hb1h.field('text', 'Link text'),
              $_4vo79m11rjcq8hb1h.field('title', 'Link title'),
              $_4vo79m11rjcq8hb1h.field('target', 'Link target'),
              $_4vo79m11rjcq8hb1h.hidden('link')
            ],
            maxFieldIndex: [
              'url',
              'text',
              'title',
              'target'
            ].length - 1,
            getInitialValue: function () {
              return $_9m6n87wajcq8ha9e.some($_ama0h311pjcq8hb19.getInfo(editor));
            },
            onExecute: function (dialog) {
              var info = me.getValue(dialog);
              $_ama0h311pjcq8hb19.applyInfo(editor, info);
              realm.restoreToolbar();
              editor.focus();
            }
          })]
      }];
  });
  var sketch$6 = function (realm, editor) {
    return $_378a61z2jcq8haoj.forToolbarStateAction(editor, 'link', 'link', function () {
      var groups = getGroups(realm, editor);
      realm.setContextToolbar(groups);
      $_8r1bu812cjcq8hb4f.forAndroid(editor, function () {
        realm.focusToolbar();
      });
      $_ama0h311pjcq8hb19.query(editor).each(function (link) {
        editor.selection.select(link.dom());
      });
    });
  };
  var $_91ptrx11ojcq8hb15 = { sketch: sketch$6 };

  var DefaultStyleFormats = [
    {
      title: 'Headings',
      items: [
        {
          title: 'Heading 1',
          format: 'h1'
        },
        {
          title: 'Heading 2',
          format: 'h2'
        },
        {
          title: 'Heading 3',
          format: 'h3'
        },
        {
          title: 'Heading 4',
          format: 'h4'
        },
        {
          title: 'Heading 5',
          format: 'h5'
        },
        {
          title: 'Heading 6',
          format: 'h6'
        }
      ]
    },
    {
      title: 'Inline',
      items: [
        {
          title: 'Bold',
          icon: 'bold',
          format: 'bold'
        },
        {
          title: 'Italic',
          icon: 'italic',
          format: 'italic'
        },
        {
          title: 'Underline',
          icon: 'underline',
          format: 'underline'
        },
        {
          title: 'Strikethrough',
          icon: 'strikethrough',
          format: 'strikethrough'
        },
        {
          title: 'Superscript',
          icon: 'superscript',
          format: 'superscript'
        },
        {
          title: 'Subscript',
          icon: 'subscript',
          format: 'subscript'
        },
        {
          title: 'Code',
          icon: 'code',
          format: 'code'
        }
      ]
    },
    {
      title: 'Blocks',
      items: [
        {
          title: 'Paragraph',
          format: 'p'
        },
        {
          title: 'Blockquote',
          format: 'blockquote'
        },
        {
          title: 'Div',
          format: 'div'
        },
        {
          title: 'Pre',
          format: 'pre'
        }
      ]
    },
    {
      title: 'Alignment',
      items: [
        {
          title: 'Left',
          icon: 'alignleft',
          format: 'alignleft'
        },
        {
          title: 'Center',
          icon: 'aligncenter',
          format: 'aligncenter'
        },
        {
          title: 'Right',
          icon: 'alignright',
          format: 'alignright'
        },
        {
          title: 'Justify',
          icon: 'alignjustify',
          format: 'alignjustify'
        }
      ]
    }
  ];

  var findRoute = function (component, transConfig, transState, route) {
    return $_f2tmkex6jcq8hach.readOptFrom(transConfig.routes(), route.start()).map($_dh3z58wbjcq8ha9h.apply).bind(function (sConfig) {
      return $_f2tmkex6jcq8hach.readOptFrom(sConfig, route.destination()).map($_dh3z58wbjcq8ha9h.apply);
    });
  };
  var getTransition = function (comp, transConfig, transState) {
    var route = getCurrentRoute(comp, transConfig, transState);
    return route.bind(function (r) {
      return getTransitionOf(comp, transConfig, transState, r);
    });
  };
  var getTransitionOf = function (comp, transConfig, transState, route) {
    return findRoute(comp, transConfig, transState, route).bind(function (r) {
      return r.transition().map(function (t) {
        return {
          transition: $_dh3z58wbjcq8ha9h.constant(t),
          route: $_dh3z58wbjcq8ha9h.constant(r)
        };
      });
    });
  };
  var disableTransition = function (comp, transConfig, transState) {
    getTransition(comp, transConfig, transState).each(function (routeTransition) {
      var t = routeTransition.transition();
      $_waygfxujcq8hajt.remove(comp.element(), t.transitionClass());
      $_3kyqh4xwjcq8hajw.remove(comp.element(), transConfig.destinationAttr());
    });
  };
  var getNewRoute = function (comp, transConfig, transState, destination) {
    return {
      start: $_dh3z58wbjcq8ha9h.constant($_3kyqh4xwjcq8hajw.get(comp.element(), transConfig.stateAttr())),
      destination: $_dh3z58wbjcq8ha9h.constant(destination)
    };
  };
  var getCurrentRoute = function (comp, transConfig, transState) {
    var el = comp.element();
    return $_3kyqh4xwjcq8hajw.has(el, transConfig.destinationAttr()) ? $_9m6n87wajcq8ha9e.some({
      start: $_dh3z58wbjcq8ha9h.constant($_3kyqh4xwjcq8hajw.get(comp.element(), transConfig.stateAttr())),
      destination: $_dh3z58wbjcq8ha9h.constant($_3kyqh4xwjcq8hajw.get(comp.element(), transConfig.destinationAttr()))
    }) : $_9m6n87wajcq8ha9e.none();
  };
  var jumpTo = function (comp, transConfig, transState, destination) {
    disableTransition(comp, transConfig, transState);
    if ($_3kyqh4xwjcq8hajw.has(comp.element(), transConfig.stateAttr()) && $_3kyqh4xwjcq8hajw.get(comp.element(), transConfig.stateAttr()) !== destination)
      transConfig.onFinish()(comp, destination);
    $_3kyqh4xwjcq8hajw.set(comp.element(), transConfig.stateAttr(), destination);
  };
  var fasttrack = function (comp, transConfig, transState, destination) {
    if ($_3kyqh4xwjcq8hajw.has(comp.element(), transConfig.destinationAttr())) {
      $_3kyqh4xwjcq8hajw.set(comp.element(), transConfig.stateAttr(), $_3kyqh4xwjcq8hajw.get(comp.element(), transConfig.destinationAttr()));
      $_3kyqh4xwjcq8hajw.remove(comp.element(), transConfig.destinationAttr());
    }
  };
  var progressTo = function (comp, transConfig, transState, destination) {
    fasttrack(comp, transConfig, transState, destination);
    var route = getNewRoute(comp, transConfig, transState, destination);
    getTransitionOf(comp, transConfig, transState, route).fold(function () {
      jumpTo(comp, transConfig, transState, destination);
    }, function (routeTransition) {
      disableTransition(comp, transConfig, transState);
      var t = routeTransition.transition();
      $_waygfxujcq8hajt.add(comp.element(), t.transitionClass());
      $_3kyqh4xwjcq8hajw.set(comp.element(), transConfig.destinationAttr(), destination);
    });
  };
  var getState = function (comp, transConfig, transState) {
    var e = comp.element();
    return $_3kyqh4xwjcq8hajw.has(e, transConfig.stateAttr()) ? $_9m6n87wajcq8ha9e.some($_3kyqh4xwjcq8hajw.get(e, transConfig.stateAttr())) : $_9m6n87wajcq8ha9e.none();
  };
  var $_b4nl3h12ijcq8hb5e = {
    findRoute: findRoute,
    disableTransition: disableTransition,
    getCurrentRoute: getCurrentRoute,
    jumpTo: jumpTo,
    progressTo: progressTo,
    getState: getState
  };

  var events$8 = function (transConfig, transState) {
    return $_dkbc99w6jcq8ha8p.derive([
      $_dkbc99w6jcq8ha8p.run($_gcr2umwxjcq8hab1.transitionend(), function (component, simulatedEvent) {
        var raw = simulatedEvent.event().raw();
        $_b4nl3h12ijcq8hb5e.getCurrentRoute(component, transConfig, transState).each(function (route) {
          $_b4nl3h12ijcq8hb5e.findRoute(component, transConfig, transState, route).each(function (rInfo) {
            rInfo.transition().each(function (rTransition) {
              if (raw.propertyName === rTransition.property()) {
                $_b4nl3h12ijcq8hb5e.jumpTo(component, transConfig, transState, route.destination());
                transConfig.onTransition()(component, route);
              }
            });
          });
        });
      }),
      $_dkbc99w6jcq8ha8p.runOnAttached(function (comp, se) {
        $_b4nl3h12ijcq8hb5e.jumpTo(comp, transConfig, transState, transConfig.initialState());
      })
    ]);
  };
  var $_cch3er12hjcq8hb5c = { events: events$8 };

  var TransitionSchema = [
    $_ah67nix2jcq8habi.defaulted('destinationAttr', 'data-transitioning-destination'),
    $_ah67nix2jcq8habi.defaulted('stateAttr', 'data-transitioning-state'),
    $_ah67nix2jcq8habi.strict('initialState'),
    $_fvpuwdytjcq8hanb.onHandler('onTransition'),
    $_fvpuwdytjcq8hanb.onHandler('onFinish'),
    $_ah67nix2jcq8habi.strictOf('routes', $_g540acxhjcq8hadd.setOf($_yvshix8jcq8hacp.value, $_g540acxhjcq8hadd.setOf($_yvshix8jcq8hacp.value, $_g540acxhjcq8hadd.objOfOnly([$_ah67nix2jcq8habi.optionObjOfOnly('transition', [
        $_ah67nix2jcq8habi.strict('property'),
        $_ah67nix2jcq8habi.strict('transitionClass')
      ])]))))
  ];

  var createRoutes = function (routes) {
    var r = {};
    $_et458cx0jcq8hab6.each(routes, function (v, k) {
      var waypoints = k.split('<->');
      r[waypoints[0]] = $_f2tmkex6jcq8hach.wrap(waypoints[1], v);
      r[waypoints[1]] = $_f2tmkex6jcq8hach.wrap(waypoints[0], v);
    });
    return r;
  };
  var createBistate = function (first, second, transitions) {
    return $_f2tmkex6jcq8hach.wrapAll([
      {
        key: first,
        value: $_f2tmkex6jcq8hach.wrap(second, transitions)
      },
      {
        key: second,
        value: $_f2tmkex6jcq8hach.wrap(first, transitions)
      }
    ]);
  };
  var createTristate = function (first, second, third, transitions) {
    return $_f2tmkex6jcq8hach.wrapAll([
      {
        key: first,
        value: $_f2tmkex6jcq8hach.wrapAll([
          {
            key: second,
            value: transitions
          },
          {
            key: third,
            value: transitions
          }
        ])
      },
      {
        key: second,
        value: $_f2tmkex6jcq8hach.wrapAll([
          {
            key: first,
            value: transitions
          },
          {
            key: third,
            value: transitions
          }
        ])
      },
      {
        key: third,
        value: $_f2tmkex6jcq8hach.wrapAll([
          {
            key: first,
            value: transitions
          },
          {
            key: second,
            value: transitions
          }
        ])
      }
    ]);
  };
  var Transitioning = $_bfiithw4jcq8ha84.create({
    fields: TransitionSchema,
    name: 'transitioning',
    active: $_cch3er12hjcq8hb5c,
    apis: $_b4nl3h12ijcq8hb5e,
    extra: {
      createRoutes: createRoutes,
      createBistate: createBistate,
      createTristate: createTristate
    }
  });

  var generateFrom$1 = function (spec, all) {
    var schema = $_dojsh2w9jcq8ha93.map(all, function (a) {
      return $_ah67nix2jcq8habi.field(a.name(), a.name(), $_27p6pex3jcq8habw.asOption(), $_g540acxhjcq8hadd.objOf([
        $_ah67nix2jcq8habi.strict('config'),
        $_ah67nix2jcq8habi.defaulted('state', $_6dyjy2xqjcq8hajl)
      ]));
    });
    var validated = $_g540acxhjcq8hadd.asStruct('component.behaviours', $_g540acxhjcq8hadd.objOf(schema), spec.behaviours).fold(function (errInfo) {
      throw new Error($_g540acxhjcq8hadd.formatError(errInfo) + '\nComplete spec:\n' + $_2k7xfnxfjcq8had9.stringify(spec, null, 2));
    }, $_dh3z58wbjcq8ha9h.identity);
    return {
      list: all,
      data: $_et458cx0jcq8hab6.map(validated, function (blobOptionThunk) {
        var blobOption = blobOptionThunk();
        return $_dh3z58wbjcq8ha9h.constant(blobOption.map(function (blob) {
          return {
            config: blob.config(),
            state: blob.state().init(blob.config())
          };
        }));
      })
    };
  };
  var getBehaviours$1 = function (bData) {
    return bData.list;
  };
  var getData = function (bData) {
    return bData.data;
  };
  var $_3qnm3912njcq8hb6s = {
    generateFrom: generateFrom$1,
    getBehaviours: getBehaviours$1,
    getData: getData
  };

  var getBehaviours = function (spec) {
    var behaviours = $_f2tmkex6jcq8hach.readOptFrom(spec, 'behaviours').getOr({});
    var keys = $_dojsh2w9jcq8ha93.filter($_et458cx0jcq8hab6.keys(behaviours), function (k) {
      return behaviours[k] !== undefined;
    });
    return $_dojsh2w9jcq8ha93.map(keys, function (k) {
      return spec.behaviours[k].me;
    });
  };
  var generateFrom = function (spec, all) {
    return $_3qnm3912njcq8hb6s.generateFrom(spec, all);
  };
  var generate$4 = function (spec) {
    var all = getBehaviours(spec);
    return generateFrom(spec, all);
  };
  var $_bqmbk412mjcq8hb6n = {
    generate: generate$4,
    generateFrom: generateFrom
  };

  var ComponentApi = $_fg1gs2xsjcq8hajn.exactly([
    'getSystem',
    'config',
    'hasConfigured',
    'spec',
    'connect',
    'disconnect',
    'element',
    'syncComponents',
    'readState',
    'components',
    'events'
  ]);

  var SystemApi = $_fg1gs2xsjcq8hajn.exactly([
    'debugInfo',
    'triggerFocus',
    'triggerEvent',
    'triggerEscape',
    'addToWorld',
    'removeFromWorld',
    'addToGui',
    'removeFromGui',
    'build',
    'getByUid',
    'getByDom',
    'broadcast',
    'broadcastOn'
  ]);

  var NoContextApi = function (getComp) {
    var fail = function (event) {
      return function () {
        throw new Error('The component must be in a context to send: ' + event + '\n' + $_2g4xv2y9jcq8hali.element(getComp().element()) + ' is not in context.');
      };
    };
    return SystemApi({
      debugInfo: $_dh3z58wbjcq8ha9h.constant('fake'),
      triggerEvent: fail('triggerEvent'),
      triggerFocus: fail('triggerFocus'),
      triggerEscape: fail('triggerEscape'),
      build: fail('build'),
      addToWorld: fail('addToWorld'),
      removeFromWorld: fail('removeFromWorld'),
      addToGui: fail('addToGui'),
      removeFromGui: fail('removeFromGui'),
      getByUid: fail('getByUid'),
      getByDom: fail('getByDom'),
      broadcast: fail('broadcast'),
      broadcastOn: fail('broadcastOn')
    });
  };

  var byInnerKey = function (data, tuple) {
    var r = {};
    $_et458cx0jcq8hab6.each(data, function (detail, key) {
      $_et458cx0jcq8hab6.each(detail, function (value, indexKey) {
        var chain = $_f2tmkex6jcq8hach.readOr(indexKey, [])(r);
        r[indexKey] = chain.concat([tuple(key, value)]);
      });
    });
    return r;
  };
  var $_smwni12sjcq8hb7l = { byInnerKey: byInnerKey };

  var behaviourDom = function (name, modification) {
    return {
      name: $_dh3z58wbjcq8ha9h.constant(name),
      modification: modification
    };
  };
  var concat = function (chain, aspect) {
    var values = $_dojsh2w9jcq8ha93.bind(chain, function (c) {
      return c.modification().getOr([]);
    });
    return $_yvshix8jcq8hacp.value($_f2tmkex6jcq8hach.wrap(aspect, values));
  };
  var onlyOne = function (chain, aspect, order) {
    if (chain.length > 1)
      return $_yvshix8jcq8hacp.error('Multiple behaviours have tried to change DOM "' + aspect + '". The guilty behaviours are: ' + $_2k7xfnxfjcq8had9.stringify($_dojsh2w9jcq8ha93.map(chain, function (b) {
        return b.name();
      })) + '. At this stage, this ' + 'is not supported. Future releases might provide strategies for resolving this.');
    else if (chain.length === 0)
      return $_yvshix8jcq8hacp.value({});
    else
      return $_yvshix8jcq8hacp.value(chain[0].modification().fold(function () {
        return {};
      }, function (m) {
        return $_f2tmkex6jcq8hach.wrap(aspect, m);
      }));
  };
  var duplicate = function (aspect, k, obj, behaviours) {
    return $_yvshix8jcq8hacp.error('Mulitple behaviours have tried to change the _' + k + '_ "' + aspect + '"' + '. The guilty behaviours are: ' + $_2k7xfnxfjcq8had9.stringify($_dojsh2w9jcq8ha93.bind(behaviours, function (b) {
      return b.modification().getOr({})[k] !== undefined ? [b.name()] : [];
    }), null, 2) + '. This is not currently supported.');
  };
  var safeMerge = function (chain, aspect) {
    var y = $_dojsh2w9jcq8ha93.foldl(chain, function (acc, c) {
      var obj = c.modification().getOr({});
      return acc.bind(function (accRest) {
        var parts = $_et458cx0jcq8hab6.mapToArray(obj, function (v, k) {
          return accRest[k] !== undefined ? duplicate(aspect, k, obj, chain) : $_yvshix8jcq8hacp.value($_f2tmkex6jcq8hach.wrap(k, v));
        });
        return $_f2tmkex6jcq8hach.consolidate(parts, accRest);
      });
    }, $_yvshix8jcq8hacp.value({}));
    return y.map(function (yValue) {
      return $_f2tmkex6jcq8hach.wrap(aspect, yValue);
    });
  };
  var mergeTypes = {
    classes: concat,
    attributes: safeMerge,
    styles: safeMerge,
    domChildren: onlyOne,
    defChildren: onlyOne,
    innerHtml: onlyOne,
    value: onlyOne
  };
  var combine$1 = function (info, baseMod, behaviours, base) {
    var behaviourDoms = $_936c00wyjcq8hab3.deepMerge({}, baseMod);
    $_dojsh2w9jcq8ha93.each(behaviours, function (behaviour) {
      behaviourDoms[behaviour.name()] = behaviour.exhibit(info, base);
    });
    var byAspect = $_smwni12sjcq8hb7l.byInnerKey(behaviourDoms, behaviourDom);
    var usedAspect = $_et458cx0jcq8hab6.map(byAspect, function (values, aspect) {
      return $_dojsh2w9jcq8ha93.bind(values, function (value) {
        return value.modification().fold(function () {
          return [];
        }, function (v) {
          return [value];
        });
      });
    });
    var modifications = $_et458cx0jcq8hab6.mapToArray(usedAspect, function (values, aspect) {
      return $_f2tmkex6jcq8hach.readOptFrom(mergeTypes, aspect).fold(function () {
        return $_yvshix8jcq8hacp.error('Unknown field type: ' + aspect);
      }, function (merger) {
        return merger(values, aspect);
      });
    });
    var consolidated = $_f2tmkex6jcq8hach.consolidate(modifications, {});
    return consolidated.map($_720ux0xkjcq8haj2.nu);
  };
  var $_7x92bz12rjcq8hb7b = { combine: combine$1 };

  var sortKeys = function (label, keyName, array, order) {
    var sliced = array.slice(0);
    try {
      var sorted = sliced.sort(function (a, b) {
        var aKey = a[keyName]();
        var bKey = b[keyName]();
        var aIndex = order.indexOf(aKey);
        var bIndex = order.indexOf(bKey);
        if (aIndex === -1)
          throw new Error('The ordering for ' + label + ' does not have an entry for ' + aKey + '.\nOrder specified: ' + $_2k7xfnxfjcq8had9.stringify(order, null, 2));
        if (bIndex === -1)
          throw new Error('The ordering for ' + label + ' does not have an entry for ' + bKey + '.\nOrder specified: ' + $_2k7xfnxfjcq8had9.stringify(order, null, 2));
        if (aIndex < bIndex)
          return -1;
        else if (bIndex < aIndex)
          return 1;
        else
          return 0;
      });
      return $_yvshix8jcq8hacp.value(sorted);
    } catch (err) {
      return $_yvshix8jcq8hacp.error([err]);
    }
  };
  var $_fyvja312ujcq8hb85 = { sortKeys: sortKeys };

  var nu$7 = function (handler, purpose) {
    return {
      handler: handler,
      purpose: $_dh3z58wbjcq8ha9h.constant(purpose)
    };
  };
  var curryArgs = function (descHandler, extraArgs) {
    return {
      handler: $_dh3z58wbjcq8ha9h.curry.apply(undefined, [descHandler.handler].concat(extraArgs)),
      purpose: descHandler.purpose
    };
  };
  var getHandler = function (descHandler) {
    return descHandler.handler;
  };
  var $_fcktxg12vjcq8hb88 = {
    nu: nu$7,
    curryArgs: curryArgs,
    getHandler: getHandler
  };

  var behaviourTuple = function (name, handler) {
    return {
      name: $_dh3z58wbjcq8ha9h.constant(name),
      handler: $_dh3z58wbjcq8ha9h.constant(handler)
    };
  };
  var nameToHandlers = function (behaviours, info) {
    var r = {};
    $_dojsh2w9jcq8ha93.each(behaviours, function (behaviour) {
      r[behaviour.name()] = behaviour.handlers(info);
    });
    return r;
  };
  var groupByEvents = function (info, behaviours, base) {
    var behaviourEvents = $_936c00wyjcq8hab3.deepMerge(base, nameToHandlers(behaviours, info));
    return $_smwni12sjcq8hb7l.byInnerKey(behaviourEvents, behaviourTuple);
  };
  var combine$2 = function (info, eventOrder, behaviours, base) {
    var byEventName = groupByEvents(info, behaviours, base);
    return combineGroups(byEventName, eventOrder);
  };
  var assemble = function (rawHandler) {
    var handler = $_2wdanjx1jcq8hab9.read(rawHandler);
    return function (component, simulatedEvent) {
      var args = Array.prototype.slice.call(arguments, 0);
      if (handler.abort.apply(undefined, args)) {
        simulatedEvent.stop();
      } else if (handler.can.apply(undefined, args)) {
        handler.run.apply(undefined, args);
      }
    };
  };
  var missingOrderError = function (eventName, tuples) {
    return new $_yvshix8jcq8hacp.error(['The event (' + eventName + ') has more than one behaviour that listens to it.\nWhen this occurs, you must ' + 'specify an event ordering for the behaviours in your spec (e.g. [ "listing", "toggling" ]).\nThe behaviours that ' + 'can trigger it are: ' + $_2k7xfnxfjcq8had9.stringify($_dojsh2w9jcq8ha93.map(tuples, function (c) {
        return c.name();
      }), null, 2)]);
  };
  var fuse$1 = function (tuples, eventOrder, eventName) {
    var order = eventOrder[eventName];
    if (!order)
      return missingOrderError(eventName, tuples);
    else
      return $_fyvja312ujcq8hb85.sortKeys('Event: ' + eventName, 'name', tuples, order).map(function (sortedTuples) {
        var handlers = $_dojsh2w9jcq8ha93.map(sortedTuples, function (tuple) {
          return tuple.handler();
        });
        return $_2wdanjx1jcq8hab9.fuse(handlers);
      });
  };
  var combineGroups = function (byEventName, eventOrder) {
    var r = $_et458cx0jcq8hab6.mapToArray(byEventName, function (tuples, eventName) {
      var combined = tuples.length === 1 ? $_yvshix8jcq8hacp.value(tuples[0].handler()) : fuse$1(tuples, eventOrder, eventName);
      return combined.map(function (handler) {
        var assembled = assemble(handler);
        var purpose = tuples.length > 1 ? $_dojsh2w9jcq8ha93.filter(eventOrder, function (o) {
          return $_dojsh2w9jcq8ha93.contains(tuples, function (t) {
            return t.name() === o;
          });
        }).join(' > ') : tuples[0].name();
        return $_f2tmkex6jcq8hach.wrap(eventName, $_fcktxg12vjcq8hb88.nu(assembled, purpose));
      });
    });
    return $_f2tmkex6jcq8hach.consolidate(r, {});
  };
  var $_evnwyn12tjcq8hb7v = { combine: combine$2 };

  var toInfo = function (spec) {
    return $_g540acxhjcq8hadd.asStruct('custom.definition', $_g540acxhjcq8hadd.objOfOnly([
      $_ah67nix2jcq8habi.field('dom', 'dom', $_27p6pex3jcq8habw.strict(), $_g540acxhjcq8hadd.objOfOnly([
        $_ah67nix2jcq8habi.strict('tag'),
        $_ah67nix2jcq8habi.defaulted('styles', {}),
        $_ah67nix2jcq8habi.defaulted('classes', []),
        $_ah67nix2jcq8habi.defaulted('attributes', {}),
        $_ah67nix2jcq8habi.option('value'),
        $_ah67nix2jcq8habi.option('innerHtml')
      ])),
      $_ah67nix2jcq8habi.strict('components'),
      $_ah67nix2jcq8habi.strict('uid'),
      $_ah67nix2jcq8habi.defaulted('events', {}),
      $_ah67nix2jcq8habi.defaulted('apis', $_dh3z58wbjcq8ha9h.constant({})),
      $_ah67nix2jcq8habi.field('eventOrder', 'eventOrder', $_27p6pex3jcq8habw.mergeWith({
        'alloy.execute': [
          'disabling',
          'alloy.base.behaviour',
          'toggling'
        ],
        'alloy.focus': [
          'alloy.base.behaviour',
          'focusing',
          'keying'
        ],
        'alloy.system.init': [
          'alloy.base.behaviour',
          'disabling',
          'toggling',
          'representing'
        ],
        'input': [
          'alloy.base.behaviour',
          'representing',
          'streaming',
          'invalidating'
        ],
        'alloy.system.detached': [
          'alloy.base.behaviour',
          'representing'
        ]
      }), $_g540acxhjcq8hadd.anyValue()),
      $_ah67nix2jcq8habi.option('domModification'),
      $_fvpuwdytjcq8hanb.snapshot('originalSpec'),
      $_ah67nix2jcq8habi.defaulted('debug.sketcher', 'unknown')
    ]), spec);
  };
  var getUid = function (info) {
    return $_f2tmkex6jcq8hach.wrap($_mgv1e10njcq8hawb.idAttr(), info.uid());
  };
  var toDefinition = function (info) {
    var base = {
      tag: info.dom().tag(),
      classes: info.dom().classes(),
      attributes: $_936c00wyjcq8hab3.deepMerge(getUid(info), info.dom().attributes()),
      styles: info.dom().styles(),
      domChildren: $_dojsh2w9jcq8ha93.map(info.components(), function (comp) {
        return comp.element();
      })
    };
    return $_an4dwdxljcq8haja.nu($_936c00wyjcq8hab3.deepMerge(base, info.dom().innerHtml().map(function (h) {
      return $_f2tmkex6jcq8hach.wrap('innerHtml', h);
    }).getOr({}), info.dom().value().map(function (h) {
      return $_f2tmkex6jcq8hach.wrap('value', h);
    }).getOr({})));
  };
  var toModification = function (info) {
    return info.domModification().fold(function () {
      return $_720ux0xkjcq8haj2.nu({});
    }, $_720ux0xkjcq8haj2.nu);
  };
  var toApis = function (info) {
    return info.apis();
  };
  var toEvents = function (info) {
    return info.events();
  };
  var $_31nq1g12wjcq8hb8b = {
    toInfo: toInfo,
    toDefinition: toDefinition,
    toModification: toModification,
    toApis: toApis,
    toEvents: toEvents
  };

  var add$3 = function (element, classes) {
    $_dojsh2w9jcq8ha93.each(classes, function (x) {
      $_waygfxujcq8hajt.add(element, x);
    });
  };
  var remove$6 = function (element, classes) {
    $_dojsh2w9jcq8ha93.each(classes, function (x) {
      $_waygfxujcq8hajt.remove(element, x);
    });
  };
  var toggle$3 = function (element, classes) {
    $_dojsh2w9jcq8ha93.each(classes, function (x) {
      $_waygfxujcq8hajt.toggle(element, x);
    });
  };
  var hasAll = function (element, classes) {
    return $_dojsh2w9jcq8ha93.forall(classes, function (clazz) {
      return $_waygfxujcq8hajt.has(element, clazz);
    });
  };
  var hasAny = function (element, classes) {
    return $_dojsh2w9jcq8ha93.exists(classes, function (clazz) {
      return $_waygfxujcq8hajt.has(element, clazz);
    });
  };
  var getNative = function (element) {
    var classList = element.dom().classList;
    var r = new Array(classList.length);
    for (var i = 0; i < classList.length; i++) {
      r[i] = classList.item(i);
    }
    return r;
  };
  var get$10 = function (element) {
    return $_5b5gdtxyjcq8hak3.supports(element) ? getNative(element) : $_5b5gdtxyjcq8hak3.get(element);
  };
  var $_4wcngm12yjcq8hb8v = {
    add: add$3,
    remove: remove$6,
    toggle: toggle$3,
    hasAll: hasAll,
    hasAny: hasAny,
    get: get$10
  };

  var getChildren = function (definition) {
    if (definition.domChildren().isSome() && definition.defChildren().isSome()) {
      throw new Error('Cannot specify children and child specs! Must be one or the other.\nDef: ' + $_an4dwdxljcq8haja.defToStr(definition));
    } else {
      return definition.domChildren().fold(function () {
        var defChildren = definition.defChildren().getOr([]);
        return $_dojsh2w9jcq8ha93.map(defChildren, renderDef);
      }, function (domChildren) {
        return domChildren;
      });
    }
  };
  var renderToDom = function (definition) {
    var subject = $_1t8d5wwtjcq8haao.fromTag(definition.tag());
    $_3kyqh4xwjcq8hajw.setAll(subject, definition.attributes().getOr({}));
    $_4wcngm12yjcq8hb8v.add(subject, definition.classes().getOr([]));
    $_bljwzsjcq8har2.setAll(subject, definition.styles().getOr({}));
    $_69dru8ybjcq8hals.set(subject, definition.innerHtml().getOr(''));
    var children = getChildren(definition);
    $_hk3r9y6jcq8hal3.append(subject, children);
    definition.value().each(function (value) {
      $_eixe2b120jcq8hb2r.set(subject, value);
    });
    return subject;
  };
  var renderDef = function (spec) {
    var definition = $_an4dwdxljcq8haja.nu(spec);
    return renderToDom(definition);
  };
  var $_91ehm512xjcq8hb8l = { renderToDom: renderToDom };

  var build$1 = function (spec) {
    var getMe = function () {
      return me;
    };
    var systemApi = Cell(NoContextApi(getMe));
    var info = $_g540acxhjcq8hadd.getOrDie($_31nq1g12wjcq8hb8b.toInfo($_936c00wyjcq8hab3.deepMerge(spec, { behaviours: undefined })));
    var bBlob = $_bqmbk412mjcq8hb6n.generate(spec);
    var bList = $_3qnm3912njcq8hb6s.getBehaviours(bBlob);
    var bData = $_3qnm3912njcq8hb6s.getData(bBlob);
    var definition = $_31nq1g12wjcq8hb8b.toDefinition(info);
    var baseModification = { 'alloy.base.modification': $_31nq1g12wjcq8hb8b.toModification(info) };
    var modification = $_7x92bz12rjcq8hb7b.combine(bData, baseModification, bList, definition).getOrDie();
    var modDefinition = $_720ux0xkjcq8haj2.merge(definition, modification);
    var item = $_91ehm512xjcq8hb8l.renderToDom(modDefinition);
    var baseEvents = { 'alloy.base.behaviour': $_31nq1g12wjcq8hb8b.toEvents(info) };
    var events = $_evnwyn12tjcq8hb7v.combine(bData, info.eventOrder(), bList, baseEvents).getOrDie();
    var subcomponents = Cell(info.components());
    var connect = function (newApi) {
      systemApi.set(newApi);
    };
    var disconnect = function () {
      systemApi.set(NoContextApi(getMe));
    };
    var syncComponents = function () {
      var children = $_4h5j2xy3jcq8hakl.children(item);
      var subs = $_dojsh2w9jcq8ha93.bind(children, function (child) {
        return systemApi.get().getByDom(child).fold(function () {
          return [];
        }, function (c) {
          return [c];
        });
      });
      subcomponents.set(subs);
    };
    var config = function (behaviour) {
      if (behaviour === $_edxw3210fjcq8hauj.apiConfig())
        return info.apis();
      var b = bData;
      var f = $_6xn7hbwzjcq8hab5.isFunction(b[behaviour.name()]) ? b[behaviour.name()] : function () {
        throw new Error('Could not find ' + behaviour.name() + ' in ' + $_2k7xfnxfjcq8had9.stringify(spec, null, 2));
      };
      return f();
    };
    var hasConfigured = function (behaviour) {
      return $_6xn7hbwzjcq8hab5.isFunction(bData[behaviour.name()]);
    };
    var readState = function (behaviourName) {
      return bData[behaviourName]().map(function (b) {
        return b.state.readState();
      }).getOr('not enabled');
    };
    var me = ComponentApi({
      getSystem: systemApi.get,
      config: config,
      hasConfigured: hasConfigured,
      spec: $_dh3z58wbjcq8ha9h.constant(spec),
      readState: readState,
      connect: connect,
      disconnect: disconnect,
      element: $_dh3z58wbjcq8ha9h.constant(item),
      syncComponents: syncComponents,
      components: subcomponents.get,
      events: $_dh3z58wbjcq8ha9h.constant(events)
    });
    return me;
  };
  var $_71wv0g12ljcq8hb6b = { build: build$1 };

  var isRecursive = function (component, originator, target) {
    return $_darej4w8jcq8ha8v.eq(originator, component.element()) && !$_darej4w8jcq8ha8v.eq(originator, target);
  };
  var $_8ya7sy12zjcq8hb8z = {
    events: $_dkbc99w6jcq8ha8p.derive([$_dkbc99w6jcq8ha8p.can($_51ilu1wwjcq8haax.focus(), function (component, simulatedEvent) {
        var originator = simulatedEvent.event().originator();
        var target = simulatedEvent.event().target();
        if (isRecursive(component, originator, target)) {
          console.warn($_51ilu1wwjcq8haax.focus() + ' did not get interpreted by the desired target. ' + '\nOriginator: ' + $_2g4xv2y9jcq8hali.element(originator) + '\nTarget: ' + $_2g4xv2y9jcq8hali.element(target) + '\nCheck the ' + $_51ilu1wwjcq8haax.focus() + ' event handlers');
          return false;
        } else {
          return true;
        }
      })])
  };

  var make$1 = function (spec) {
    return spec;
  };
  var $_1fnec0130jcq8hb92 = { make: make$1 };

  var buildSubcomponents = function (spec) {
    var components = $_f2tmkex6jcq8hach.readOr('components', [])(spec);
    return $_dojsh2w9jcq8ha93.map(components, build);
  };
  var buildFromSpec = function (userSpec) {
    var spec = $_1fnec0130jcq8hb92.make(userSpec);
    var components = buildSubcomponents(spec);
    var completeSpec = $_936c00wyjcq8hab3.deepMerge($_8ya7sy12zjcq8hb8z, spec, $_f2tmkex6jcq8hach.wrap('components', components));
    return $_yvshix8jcq8hacp.value($_71wv0g12ljcq8hb6b.build(completeSpec));
  };
  var text = function (textContent) {
    var element = $_1t8d5wwtjcq8haao.fromText(textContent);
    return external({ element: element });
  };
  var external = function (spec) {
    var extSpec = $_g540acxhjcq8hadd.asStructOrDie('external.component', $_g540acxhjcq8hadd.objOfOnly([
      $_ah67nix2jcq8habi.strict('element'),
      $_ah67nix2jcq8habi.option('uid')
    ]), spec);
    var systemApi = Cell(NoContextApi());
    var connect = function (newApi) {
      systemApi.set(newApi);
    };
    var disconnect = function () {
      systemApi.set(NoContextApi(function () {
        return me;
      }));
    };
    extSpec.uid().each(function (uid) {
      $_3r222m10mjcq8haw3.writeOnly(extSpec.element(), uid);
    });
    var me = ComponentApi({
      getSystem: systemApi.get,
      config: $_9m6n87wajcq8ha9e.none,
      hasConfigured: $_dh3z58wbjcq8ha9h.constant(false),
      connect: connect,
      disconnect: disconnect,
      element: $_dh3z58wbjcq8ha9h.constant(extSpec.element()),
      spec: $_dh3z58wbjcq8ha9h.constant(spec),
      readState: $_dh3z58wbjcq8ha9h.constant('No state'),
      syncComponents: $_dh3z58wbjcq8ha9h.noop,
      components: $_dh3z58wbjcq8ha9h.constant([]),
      events: $_dh3z58wbjcq8ha9h.constant({})
    });
    return $_edxw3210fjcq8hauj.premade(me);
  };
  var build = function (rawUserSpec) {
    return $_edxw3210fjcq8hauj.getPremade(rawUserSpec).fold(function () {
      var userSpecWithUid = $_936c00wyjcq8hab3.deepMerge({ uid: $_3r222m10mjcq8haw3.generate('') }, rawUserSpec);
      return buildFromSpec(userSpecWithUid).getOrDie();
    }, function (prebuilt) {
      return prebuilt;
    });
  };
  var $_1e8bjm12kjcq8hb5s = {
    build: build,
    premade: $_edxw3210fjcq8hauj.premade,
    external: external,
    text: text
  };

  var hoverEvent = 'alloy.item-hover';
  var focusEvent = 'alloy.item-focus';
  var onHover = function (item) {
    if ($_dgsby1ygjcq8ham1.search(item.element()).isNone() || Focusing.isFocused(item)) {
      if (!Focusing.isFocused(item))
        Focusing.focus(item);
      $_3yqf3awvjcq8haat.emitWith(item, hoverEvent, { item: item });
    }
  };
  var onFocus = function (item) {
    $_3yqf3awvjcq8haat.emitWith(item, focusEvent, { item: item });
  };
  var $_7vw7b1134jcq8hb9n = {
    hover: $_dh3z58wbjcq8ha9h.constant(hoverEvent),
    focus: $_dh3z58wbjcq8ha9h.constant(focusEvent),
    onHover: onHover,
    onFocus: onFocus
  };

  var builder = function (info) {
    return {
      dom: $_936c00wyjcq8hab3.deepMerge(info.dom(), { attributes: { role: info.toggling().isSome() ? 'menuitemcheckbox' : 'menuitem' } }),
      behaviours: $_936c00wyjcq8hab3.deepMerge($_bfiithw4jcq8ha84.derive([
        info.toggling().fold(Toggling.revoke, function (tConfig) {
          return Toggling.config($_936c00wyjcq8hab3.deepMerge({ aria: { mode: 'checked' } }, tConfig));
        }),
        Focusing.config({
          ignore: info.ignoreFocus(),
          onFocus: function (component) {
            $_7vw7b1134jcq8hb9n.onFocus(component);
          }
        }),
        Keying.config({ mode: 'execution' }),
        me.config({
          store: {
            mode: 'memory',
            initialValue: info.data()
          }
        })
      ]), info.itemBehaviours()),
      events: $_dkbc99w6jcq8ha8p.derive([
        $_dkbc99w6jcq8ha8p.runWithTarget($_51ilu1wwjcq8haax.tapOrClick(), $_3yqf3awvjcq8haat.emitExecute),
        $_dkbc99w6jcq8ha8p.cutter($_gcr2umwxjcq8hab1.mousedown()),
        $_dkbc99w6jcq8ha8p.run($_gcr2umwxjcq8hab1.mouseover(), $_7vw7b1134jcq8hb9n.onHover),
        $_dkbc99w6jcq8ha8p.run($_51ilu1wwjcq8haax.focusItem(), Focusing.focus)
      ]),
      components: info.components(),
      domModification: info.domModification()
    };
  };
  var schema$11 = [
    $_ah67nix2jcq8habi.strict('data'),
    $_ah67nix2jcq8habi.strict('components'),
    $_ah67nix2jcq8habi.strict('dom'),
    $_ah67nix2jcq8habi.option('toggling'),
    $_ah67nix2jcq8habi.defaulted('itemBehaviours', {}),
    $_ah67nix2jcq8habi.defaulted('ignoreFocus', false),
    $_ah67nix2jcq8habi.defaulted('domModification', {}),
    $_fvpuwdytjcq8hanb.output('builder', builder)
  ];

  var builder$1 = function (detail) {
    return {
      dom: detail.dom(),
      components: detail.components(),
      events: $_dkbc99w6jcq8ha8p.derive([$_dkbc99w6jcq8ha8p.stopper($_51ilu1wwjcq8haax.focusItem())])
    };
  };
  var schema$12 = [
    $_ah67nix2jcq8habi.strict('dom'),
    $_ah67nix2jcq8habi.strict('components'),
    $_fvpuwdytjcq8hanb.output('builder', builder$1)
  ];

  var owner$2 = 'item-widget';
  var partTypes = [$_50i5hr10kjcq8havc.required({
      name: 'widget',
      overrides: function (detail) {
        return {
          behaviours: $_bfiithw4jcq8ha84.derive([me.config({
              store: {
                mode: 'manual',
                getValue: function (component) {
                  return detail.data();
                },
                setValue: function () {
                }
              }
            })])
        };
      }
    })];
  var $_ew4sel137jcq8hb9z = {
    owner: $_dh3z58wbjcq8ha9h.constant(owner$2),
    parts: $_dh3z58wbjcq8ha9h.constant(partTypes)
  };

  var builder$2 = function (info) {
    var subs = $_70h8qs10ijcq8haut.substitutes($_ew4sel137jcq8hb9z.owner(), info, $_ew4sel137jcq8hb9z.parts());
    var components = $_70h8qs10ijcq8haut.components($_ew4sel137jcq8hb9z.owner(), info, subs.internals());
    var focusWidget = function (component) {
      return $_70h8qs10ijcq8haut.getPart(component, info, 'widget').map(function (widget) {
        Keying.focusIn(widget);
        return widget;
      });
    };
    var onHorizontalArrow = function (component, simulatedEvent) {
      return $_bttiggzxjcq8harn.inside(simulatedEvent.event().target()) ? $_9m6n87wajcq8ha9e.none() : function () {
        if (info.autofocus()) {
          simulatedEvent.setSource(component.element());
          return $_9m6n87wajcq8ha9e.none();
        } else {
          return $_9m6n87wajcq8ha9e.none();
        }
      }();
    };
    return $_936c00wyjcq8hab3.deepMerge({
      dom: info.dom(),
      components: components,
      domModification: info.domModification(),
      events: $_dkbc99w6jcq8ha8p.derive([
        $_dkbc99w6jcq8ha8p.runOnExecute(function (component, simulatedEvent) {
          focusWidget(component).each(function (widget) {
            simulatedEvent.stop();
          });
        }),
        $_dkbc99w6jcq8ha8p.run($_gcr2umwxjcq8hab1.mouseover(), $_7vw7b1134jcq8hb9n.onHover),
        $_dkbc99w6jcq8ha8p.run($_51ilu1wwjcq8haax.focusItem(), function (component, simulatedEvent) {
          if (info.autofocus())
            focusWidget(component);
          else
            Focusing.focus(component);
        })
      ]),
      behaviours: $_bfiithw4jcq8ha84.derive([
        me.config({
          store: {
            mode: 'memory',
            initialValue: info.data()
          }
        }),
        Focusing.config({
          onFocus: function (component) {
            $_7vw7b1134jcq8hb9n.onFocus(component);
          }
        }),
        Keying.config({
          mode: 'special',
          onLeft: onHorizontalArrow,
          onRight: onHorizontalArrow,
          onEscape: function (component, simulatedEvent) {
            if (!Focusing.isFocused(component) && !info.autofocus()) {
              Focusing.focus(component);
              return $_9m6n87wajcq8ha9e.some(true);
            } else if (info.autofocus()) {
              simulatedEvent.setSource(component.element());
              return $_9m6n87wajcq8ha9e.none();
            } else {
              return $_9m6n87wajcq8ha9e.none();
            }
          }
        })
      ])
    });
  };
  var schema$13 = [
    $_ah67nix2jcq8habi.strict('uid'),
    $_ah67nix2jcq8habi.strict('data'),
    $_ah67nix2jcq8habi.strict('components'),
    $_ah67nix2jcq8habi.strict('dom'),
    $_ah67nix2jcq8habi.defaulted('autofocus', false),
    $_ah67nix2jcq8habi.defaulted('domModification', {}),
    $_70h8qs10ijcq8haut.defaultUidsSchema($_ew4sel137jcq8hb9z.parts()),
    $_fvpuwdytjcq8hanb.output('builder', builder$2)
  ];

  var itemSchema$1 = $_g540acxhjcq8hadd.choose('type', {
    widget: schema$13,
    item: schema$11,
    separator: schema$12
  });
  var configureGrid = function (detail, movementInfo) {
    return {
      mode: 'flatgrid',
      selector: '.' + detail.markers().item(),
      initSize: {
        numColumns: movementInfo.initSize().numColumns(),
        numRows: movementInfo.initSize().numRows()
      },
      focusManager: detail.focusManager()
    };
  };
  var configureMenu = function (detail, movementInfo) {
    return {
      mode: 'menu',
      selector: '.' + detail.markers().item(),
      moveOnTab: movementInfo.moveOnTab(),
      focusManager: detail.focusManager()
    };
  };
  var parts = [$_50i5hr10kjcq8havc.group({
      factory: {
        sketch: function (spec) {
          var itemInfo = $_g540acxhjcq8hadd.asStructOrDie('menu.spec item', itemSchema$1, spec);
          return itemInfo.builder()(itemInfo);
        }
      },
      name: 'items',
      unit: 'item',
      defaults: function (detail, u) {
        var fallbackUid = $_3r222m10mjcq8haw3.generate('');
        return $_936c00wyjcq8hab3.deepMerge({ uid: fallbackUid }, u);
      },
      overrides: function (detail, u) {
        return {
          type: u.type,
          ignoreFocus: detail.fakeFocus(),
          domModification: { classes: [detail.markers().item()] }
        };
      }
    })];
  var schema$10 = [
    $_ah67nix2jcq8habi.strict('value'),
    $_ah67nix2jcq8habi.strict('items'),
    $_ah67nix2jcq8habi.strict('dom'),
    $_ah67nix2jcq8habi.strict('components'),
    $_ah67nix2jcq8habi.defaulted('eventOrder', {}),
    $_b4pjyg10djcq8hau7.field('menuBehaviours', [
      Highlighting,
      me,
      Composing,
      Keying
    ]),
    $_ah67nix2jcq8habi.defaultedOf('movement', {
      mode: 'menu',
      moveOnTab: true
    }, $_g540acxhjcq8hadd.choose('mode', {
      grid: [
        $_fvpuwdytjcq8hanb.initSize(),
        $_fvpuwdytjcq8hanb.output('config', configureGrid)
      ],
      menu: [
        $_ah67nix2jcq8habi.defaulted('moveOnTab', true),
        $_fvpuwdytjcq8hanb.output('config', configureMenu)
      ]
    })),
    $_fvpuwdytjcq8hanb.itemMarkers(),
    $_ah67nix2jcq8habi.defaulted('fakeFocus', false),
    $_ah67nix2jcq8habi.defaulted('focusManager', $_d956zszgjcq8hapx.dom()),
    $_fvpuwdytjcq8hanb.onHandler('onHighlight')
  ];
  var $_3iwx46132jcq8hb95 = {
    name: $_dh3z58wbjcq8ha9h.constant('Menu'),
    schema: $_dh3z58wbjcq8ha9h.constant(schema$10),
    parts: $_dh3z58wbjcq8ha9h.constant(parts)
  };

  var focusEvent$1 = 'alloy.menu-focus';
  var $_bx2y3z139jcq8hba7 = { focus: $_dh3z58wbjcq8ha9h.constant(focusEvent$1) };

  var make$2 = function (detail, components, spec, externals) {
    return $_936c00wyjcq8hab3.deepMerge({
      dom: $_936c00wyjcq8hab3.deepMerge(detail.dom(), { attributes: { role: 'menu' } }),
      uid: detail.uid(),
      behaviours: $_936c00wyjcq8hab3.deepMerge($_bfiithw4jcq8ha84.derive([
        Highlighting.config({
          highlightClass: detail.markers().selectedItem(),
          itemClass: detail.markers().item(),
          onHighlight: detail.onHighlight()
        }),
        me.config({
          store: {
            mode: 'memory',
            initialValue: detail.value()
          }
        }),
        Composing.config({ find: $_dh3z58wbjcq8ha9h.identity }),
        Keying.config(detail.movement().config()(detail, detail.movement()))
      ]), $_b4pjyg10djcq8hau7.get(detail.menuBehaviours())),
      events: $_dkbc99w6jcq8ha8p.derive([
        $_dkbc99w6jcq8ha8p.run($_7vw7b1134jcq8hb9n.focus(), function (menu, simulatedEvent) {
          var event = simulatedEvent.event();
          menu.getSystem().getByDom(event.target()).each(function (item) {
            Highlighting.highlight(menu, item);
            simulatedEvent.stop();
            $_3yqf3awvjcq8haat.emitWith(menu, $_bx2y3z139jcq8hba7.focus(), {
              menu: menu,
              item: item
            });
          });
        }),
        $_dkbc99w6jcq8ha8p.run($_7vw7b1134jcq8hb9n.hover(), function (menu, simulatedEvent) {
          var item = simulatedEvent.event().item();
          Highlighting.highlight(menu, item);
        })
      ]),
      components: components,
      eventOrder: detail.eventOrder()
    });
  };
  var $_3cugmu138jcq8hba3 = { make: make$2 };

  var Menu = $_cocv7l10ejcq8hauc.composite({
    name: 'Menu',
    configFields: $_3iwx46132jcq8hb95.schema(),
    partFields: $_3iwx46132jcq8hb95.parts(),
    factory: $_3cugmu138jcq8hba3.make
  });

  var preserve$2 = function (f, container) {
    var ownerDoc = $_4h5j2xy3jcq8hakl.owner(container);
    var refocus = $_dgsby1ygjcq8ham1.active(ownerDoc).bind(function (focused) {
      var hasFocus = function (elem) {
        return $_darej4w8jcq8ha8v.eq(focused, elem);
      };
      return hasFocus(container) ? $_9m6n87wajcq8ha9e.some(container) : $_1vm5o1yijcq8ham7.descendant(container, hasFocus);
    });
    var result = f(container);
    refocus.each(function (oldFocus) {
      $_dgsby1ygjcq8ham1.active(ownerDoc).filter(function (newFocus) {
        return $_darej4w8jcq8ha8v.eq(newFocus, oldFocus);
      }).orThunk(function () {
        $_dgsby1ygjcq8ham1.focus(oldFocus);
      });
    });
    return result;
  };
  var $_ara5pj13djcq8hbak = { preserve: preserve$2 };

  var set$7 = function (component, replaceConfig, replaceState, data) {
    $_8oadbiy1jcq8haka.detachChildren(component);
    $_ara5pj13djcq8hbak.preserve(function () {
      var children = $_dojsh2w9jcq8ha93.map(data, component.getSystem().build);
      $_dojsh2w9jcq8ha93.each(children, function (l) {
        $_8oadbiy1jcq8haka.attach(component, l);
      });
    }, component.element());
  };
  var insert = function (component, replaceConfig, insertion, childSpec) {
    var child = component.getSystem().build(childSpec);
    $_8oadbiy1jcq8haka.attachWith(component, child, insertion);
  };
  var append$2 = function (component, replaceConfig, replaceState, appendee) {
    insert(component, replaceConfig, $_1lvp6jy2jcq8hakj.append, appendee);
  };
  var prepend$2 = function (component, replaceConfig, replaceState, prependee) {
    insert(component, replaceConfig, $_1lvp6jy2jcq8hakj.prepend, prependee);
  };
  var remove$7 = function (component, replaceConfig, replaceState, removee) {
    var children = contents(component, replaceConfig);
    var foundChild = $_dojsh2w9jcq8ha93.find(children, function (child) {
      return $_darej4w8jcq8ha8v.eq(removee.element(), child.element());
    });
    foundChild.each($_8oadbiy1jcq8haka.detach);
  };
  var contents = function (component, replaceConfig) {
    return component.components();
  };
  var $_cjvh6o13cjcq8hbag = {
    append: append$2,
    prepend: prepend$2,
    remove: remove$7,
    set: set$7,
    contents: contents
  };

  var Replacing = $_bfiithw4jcq8ha84.create({
    fields: [],
    name: 'replacing',
    apis: $_cjvh6o13cjcq8hbag
  });

  var transpose = function (obj) {
    return $_et458cx0jcq8hab6.tupleMap(obj, function (v, k) {
      return {
        k: v,
        v: k
      };
    });
  };
  var trace = function (items, byItem, byMenu, finish) {
    return $_f2tmkex6jcq8hach.readOptFrom(byMenu, finish).bind(function (triggerItem) {
      return $_f2tmkex6jcq8hach.readOptFrom(items, triggerItem).bind(function (triggerMenu) {
        var rest = trace(items, byItem, byMenu, triggerMenu);
        return $_9m6n87wajcq8ha9e.some([triggerMenu].concat(rest));
      });
    }).getOr([]);
  };
  var generate$5 = function (menus, expansions) {
    var items = {};
    $_et458cx0jcq8hab6.each(menus, function (menuItems, menu) {
      $_dojsh2w9jcq8ha93.each(menuItems, function (item) {
        items[item] = menu;
      });
    });
    var byItem = expansions;
    var byMenu = transpose(expansions);
    var menuPaths = $_et458cx0jcq8hab6.map(byMenu, function (triggerItem, submenu) {
      return [submenu].concat(trace(items, byItem, byMenu, submenu));
    });
    return $_et458cx0jcq8hab6.map(items, function (path) {
      return $_f2tmkex6jcq8hach.readOptFrom(menuPaths, path).getOr([path]);
    });
  };
  var $_7gpz7313gjcq8hbbp = { generate: generate$5 };

  var LayeredState = function () {
    var expansions = Cell({});
    var menus = Cell({});
    var paths = Cell({});
    var primary = Cell($_9m6n87wajcq8ha9e.none());
    var toItemValues = Cell($_dh3z58wbjcq8ha9h.constant([]));
    var clear = function () {
      expansions.set({});
      menus.set({});
      paths.set({});
      primary.set($_9m6n87wajcq8ha9e.none());
    };
    var isClear = function () {
      return primary.get().isNone();
    };
    var setContents = function (sPrimary, sMenus, sExpansions, sToItemValues) {
      primary.set($_9m6n87wajcq8ha9e.some(sPrimary));
      expansions.set(sExpansions);
      menus.set(sMenus);
      toItemValues.set(sToItemValues);
      var menuValues = sToItemValues(sMenus);
      var sPaths = $_7gpz7313gjcq8hbbp.generate(menuValues, sExpansions);
      paths.set(sPaths);
    };
    var expand = function (itemValue) {
      return $_f2tmkex6jcq8hach.readOptFrom(expansions.get(), itemValue).map(function (menu) {
        var current = $_f2tmkex6jcq8hach.readOptFrom(paths.get(), itemValue).getOr([]);
        return [menu].concat(current);
      });
    };
    var collapse = function (itemValue) {
      return $_f2tmkex6jcq8hach.readOptFrom(paths.get(), itemValue).bind(function (path) {
        return path.length > 1 ? $_9m6n87wajcq8ha9e.some(path.slice(1)) : $_9m6n87wajcq8ha9e.none();
      });
    };
    var refresh = function (itemValue) {
      return $_f2tmkex6jcq8hach.readOptFrom(paths.get(), itemValue);
    };
    var lookupMenu = function (menuValue) {
      return $_f2tmkex6jcq8hach.readOptFrom(menus.get(), menuValue);
    };
    var otherMenus = function (path) {
      var menuValues = toItemValues.get()(menus.get());
      return $_dojsh2w9jcq8ha93.difference($_et458cx0jcq8hab6.keys(menuValues), path);
    };
    var getPrimary = function () {
      return primary.get().bind(lookupMenu);
    };
    var getMenus = function () {
      return menus.get();
    };
    return {
      setContents: setContents,
      expand: expand,
      refresh: refresh,
      collapse: collapse,
      lookupMenu: lookupMenu,
      otherMenus: otherMenus,
      getPrimary: getPrimary,
      getMenus: getMenus,
      clear: clear,
      isClear: isClear
    };
  };

  var make$3 = function (detail, rawUiSpec) {
    var buildMenus = function (container, menus) {
      return $_et458cx0jcq8hab6.map(menus, function (spec, name) {
        var data = Menu.sketch($_936c00wyjcq8hab3.deepMerge(spec, {
          value: name,
          items: spec.items,
          markers: $_f2tmkex6jcq8hach.narrow(rawUiSpec.markers, [
            'item',
            'selectedItem'
          ]),
          fakeFocus: detail.fakeFocus(),
          onHighlight: detail.onHighlight(),
          focusManager: detail.fakeFocus() ? $_d956zszgjcq8hapx.highlights() : $_d956zszgjcq8hapx.dom()
        }));
        return container.getSystem().build(data);
      });
    };
    var state = LayeredState();
    var setup = function (container) {
      var componentMap = buildMenus(container, detail.data().menus());
      state.setContents(detail.data().primary(), componentMap, detail.data().expansions(), function (sMenus) {
        return toMenuValues(container, sMenus);
      });
      return state.getPrimary();
    };
    var getItemValue = function (item) {
      return me.getValue(item).value;
    };
    var toMenuValues = function (container, sMenus) {
      return $_et458cx0jcq8hab6.map(detail.data().menus(), function (data, menuName) {
        return $_dojsh2w9jcq8ha93.bind(data.items, function (item) {
          return item.type === 'separator' ? [] : [item.data.value];
        });
      });
    };
    var setActiveMenu = function (container, menu) {
      Highlighting.highlight(container, menu);
      Highlighting.getHighlighted(menu).orThunk(function () {
        return Highlighting.getFirst(menu);
      }).each(function (item) {
        $_3yqf3awvjcq8haat.dispatch(container, item.element(), $_51ilu1wwjcq8haax.focusItem());
      });
    };
    var getMenus = function (state, menuValues) {
      return $_4d7j4zyejcq8halz.cat($_dojsh2w9jcq8ha93.map(menuValues, state.lookupMenu));
    };
    var updateMenuPath = function (container, state, path) {
      return $_9m6n87wajcq8ha9e.from(path[0]).bind(state.lookupMenu).map(function (activeMenu) {
        var rest = getMenus(state, path.slice(1));
        $_dojsh2w9jcq8ha93.each(rest, function (r) {
          $_waygfxujcq8hajt.add(r.element(), detail.markers().backgroundMenu());
        });
        if (!$_4axtmsy7jcq8hal6.inBody(activeMenu.element())) {
          Replacing.append(container, $_1e8bjm12kjcq8hb5s.premade(activeMenu));
        }
        $_4wcngm12yjcq8hb8v.remove(activeMenu.element(), [detail.markers().backgroundMenu()]);
        setActiveMenu(container, activeMenu);
        var others = getMenus(state, state.otherMenus(path));
        $_dojsh2w9jcq8ha93.each(others, function (o) {
          $_4wcngm12yjcq8hb8v.remove(o.element(), [detail.markers().backgroundMenu()]);
          if (!detail.stayInDom())
            Replacing.remove(container, o);
        });
        return activeMenu;
      });
    };
    var expandRight = function (container, item) {
      var value = getItemValue(item);
      return state.expand(value).bind(function (path) {
        $_9m6n87wajcq8ha9e.from(path[0]).bind(state.lookupMenu).each(function (activeMenu) {
          if (!$_4axtmsy7jcq8hal6.inBody(activeMenu.element())) {
            Replacing.append(container, $_1e8bjm12kjcq8hb5s.premade(activeMenu));
          }
          detail.onOpenSubmenu()(container, item, activeMenu);
          Highlighting.highlightFirst(activeMenu);
        });
        return updateMenuPath(container, state, path);
      });
    };
    var collapseLeft = function (container, item) {
      var value = getItemValue(item);
      return state.collapse(value).bind(function (path) {
        return updateMenuPath(container, state, path).map(function (activeMenu) {
          detail.onCollapseMenu()(container, item, activeMenu);
          return activeMenu;
        });
      });
    };
    var updateView = function (container, item) {
      var value = getItemValue(item);
      return state.refresh(value).bind(function (path) {
        return updateMenuPath(container, state, path);
      });
    };
    var onRight = function (container, item) {
      return $_bttiggzxjcq8harn.inside(item.element()) ? $_9m6n87wajcq8ha9e.none() : expandRight(container, item);
    };
    var onLeft = function (container, item) {
      return $_bttiggzxjcq8harn.inside(item.element()) ? $_9m6n87wajcq8ha9e.none() : collapseLeft(container, item);
    };
    var onEscape = function (container, item) {
      return collapseLeft(container, item).orThunk(function () {
        return detail.onEscape()(container, item);
      });
    };
    var keyOnItem = function (f) {
      return function (container, simulatedEvent) {
        return $_9rnmwhzmjcq8haqn.closest(simulatedEvent.getSource(), '.' + detail.markers().item()).bind(function (target) {
          return container.getSystem().getByDom(target).bind(function (item) {
            return f(container, item);
          });
        });
      };
    };
    var events = $_dkbc99w6jcq8ha8p.derive([
      $_dkbc99w6jcq8ha8p.run($_bx2y3z139jcq8hba7.focus(), function (sandbox, simulatedEvent) {
        var menu = simulatedEvent.event().menu();
        Highlighting.highlight(sandbox, menu);
      }),
      $_dkbc99w6jcq8ha8p.runOnExecute(function (sandbox, simulatedEvent) {
        var target = simulatedEvent.event().target();
        return sandbox.getSystem().getByDom(target).bind(function (item) {
          var itemValue = getItemValue(item);
          if (itemValue.indexOf('collapse-item') === 0) {
            return collapseLeft(sandbox, item);
          }
          return expandRight(sandbox, item).orThunk(function () {
            return detail.onExecute()(sandbox, item);
          });
        });
      }),
      $_dkbc99w6jcq8ha8p.runOnAttached(function (container, simulatedEvent) {
        setup(container).each(function (primary) {
          Replacing.append(container, $_1e8bjm12kjcq8hb5s.premade(primary));
          if (detail.openImmediately()) {
            setActiveMenu(container, primary);
            detail.onOpenMenu()(container, primary);
          }
        });
      })
    ].concat(detail.navigateOnHover() ? [$_dkbc99w6jcq8ha8p.run($_7vw7b1134jcq8hb9n.hover(), function (sandbox, simulatedEvent) {
        var item = simulatedEvent.event().item();
        updateView(sandbox, item);
        expandRight(sandbox, item);
        detail.onHover()(sandbox, item);
      })] : []));
    var collapseMenuApi = function (container) {
      Highlighting.getHighlighted(container).each(function (currentMenu) {
        Highlighting.getHighlighted(currentMenu).each(function (currentItem) {
          collapseLeft(container, currentItem);
        });
      });
    };
    return {
      uid: detail.uid(),
      dom: detail.dom(),
      behaviours: $_936c00wyjcq8hab3.deepMerge($_bfiithw4jcq8ha84.derive([
        Keying.config({
          mode: 'special',
          onRight: keyOnItem(onRight),
          onLeft: keyOnItem(onLeft),
          onEscape: keyOnItem(onEscape),
          focusIn: function (container, keyInfo) {
            state.getPrimary().each(function (primary) {
              $_3yqf3awvjcq8haat.dispatch(container, primary.element(), $_51ilu1wwjcq8haax.focusItem());
            });
          }
        }),
        Highlighting.config({
          highlightClass: detail.markers().selectedMenu(),
          itemClass: detail.markers().menu()
        }),
        Composing.config({
          find: function (container) {
            return Highlighting.getHighlighted(container);
          }
        }),
        Replacing.config({})
      ]), $_b4pjyg10djcq8hau7.get(detail.tmenuBehaviours())),
      eventOrder: detail.eventOrder(),
      apis: { collapseMenu: collapseMenuApi },
      events: events
    };
  };
  var $_48j5ti13ejcq8hbat = {
    make: make$3,
    collapseItem: $_dh3z58wbjcq8ha9h.constant('collapse-item')
  };

  var tieredData = function (primary, menus, expansions) {
    return {
      primary: primary,
      menus: menus,
      expansions: expansions
    };
  };
  var singleData = function (name, menu) {
    return {
      primary: name,
      menus: $_f2tmkex6jcq8hach.wrap(name, menu),
      expansions: {}
    };
  };
  var collapseItem = function (text) {
    return {
      value: $_8zlm8d10gjcq8hauo.generate($_48j5ti13ejcq8hbat.collapseItem()),
      text: text
    };
  };
  var TieredMenu = $_cocv7l10ejcq8hauc.single({
    name: 'TieredMenu',
    configFields: [
      $_fvpuwdytjcq8hanb.onStrictKeyboardHandler('onExecute'),
      $_fvpuwdytjcq8hanb.onStrictKeyboardHandler('onEscape'),
      $_fvpuwdytjcq8hanb.onStrictHandler('onOpenMenu'),
      $_fvpuwdytjcq8hanb.onStrictHandler('onOpenSubmenu'),
      $_fvpuwdytjcq8hanb.onHandler('onCollapseMenu'),
      $_ah67nix2jcq8habi.defaulted('openImmediately', true),
      $_ah67nix2jcq8habi.strictObjOf('data', [
        $_ah67nix2jcq8habi.strict('primary'),
        $_ah67nix2jcq8habi.strict('menus'),
        $_ah67nix2jcq8habi.strict('expansions')
      ]),
      $_ah67nix2jcq8habi.defaulted('fakeFocus', false),
      $_fvpuwdytjcq8hanb.onHandler('onHighlight'),
      $_fvpuwdytjcq8hanb.onHandler('onHover'),
      $_fvpuwdytjcq8hanb.tieredMenuMarkers(),
      $_ah67nix2jcq8habi.strict('dom'),
      $_ah67nix2jcq8habi.defaulted('navigateOnHover', true),
      $_ah67nix2jcq8habi.defaulted('stayInDom', false),
      $_b4pjyg10djcq8hau7.field('tmenuBehaviours', [
        Keying,
        Highlighting,
        Composing,
        Replacing
      ]),
      $_ah67nix2jcq8habi.defaulted('eventOrder', {})
    ],
    apis: {
      collapseMenu: function (apis, tmenu) {
        apis.collapseMenu(tmenu);
      }
    },
    factory: $_48j5ti13ejcq8hbat.make,
    extraApis: {
      tieredData: tieredData,
      singleData: singleData,
      collapseItem: collapseItem
    }
  });

  var scrollable = $_30duqlz1jcq8haoh.resolve('scrollable');
  var register$1 = function (element) {
    $_waygfxujcq8hajt.add(element, scrollable);
  };
  var deregister = function (element) {
    $_waygfxujcq8hajt.remove(element, scrollable);
  };
  var $_8r8euk13hjcq8hbbx = {
    register: register$1,
    deregister: deregister,
    scrollable: $_dh3z58wbjcq8ha9h.constant(scrollable)
  };

  var getValue$4 = function (item) {
    return $_f2tmkex6jcq8hach.readOptFrom(item, 'format').getOr(item.title);
  };
  var convert$1 = function (formats, memMenuThunk) {
    var mainMenu = makeMenu('Styles', [].concat($_dojsh2w9jcq8ha93.map(formats.items, function (k) {
      return makeItem(getValue$4(k), k.title, k.isSelected(), k.getPreview(), $_f2tmkex6jcq8hach.hasKey(formats.expansions, getValue$4(k)));
    })), memMenuThunk, false);
    var submenus = $_et458cx0jcq8hab6.map(formats.menus, function (menuItems, menuName) {
      var items = $_dojsh2w9jcq8ha93.map(menuItems, function (item) {
        return makeItem(getValue$4(item), item.title, item.isSelected !== undefined ? item.isSelected() : false, item.getPreview !== undefined ? item.getPreview() : '', $_f2tmkex6jcq8hach.hasKey(formats.expansions, getValue$4(item)));
      });
      return makeMenu(menuName, items, memMenuThunk, true);
    });
    var menus = $_936c00wyjcq8hab3.deepMerge(submenus, $_f2tmkex6jcq8hach.wrap('styles', mainMenu));
    var tmenu = TieredMenu.tieredData('styles', menus, formats.expansions);
    return { tmenu: tmenu };
  };
  var makeItem = function (value, text, selected, preview, isMenu) {
    return {
      data: {
        value: value,
        text: text
      },
      type: 'item',
      dom: {
        tag: 'div',
        classes: isMenu ? [$_30duqlz1jcq8haoh.resolve('styles-item-is-menu')] : []
      },
      toggling: {
        toggleOnExecute: false,
        toggleClass: $_30duqlz1jcq8haoh.resolve('format-matches'),
        selected: selected
      },
      itemBehaviours: $_bfiithw4jcq8ha84.derive(isMenu ? [] : [$_dnir0tz0jcq8hao8.format(value, function (comp, status) {
          var toggle = status ? Toggling.on : Toggling.off;
          toggle(comp);
        })]),
      components: [{
          dom: {
            tag: 'div',
            attributes: { style: preview },
            innerHtml: text
          }
        }]
    };
  };
  var makeMenu = function (value, items, memMenuThunk, collapsable) {
    return {
      value: value,
      dom: { tag: 'div' },
      components: [
        Button.sketch({
          dom: {
            tag: 'div',
            classes: [$_30duqlz1jcq8haoh.resolve('styles-collapser')]
          },
          components: collapsable ? [
            {
              dom: {
                tag: 'span',
                classes: [$_30duqlz1jcq8haoh.resolve('styles-collapse-icon')]
              }
            },
            $_1e8bjm12kjcq8hb5s.text(value)
          ] : [$_1e8bjm12kjcq8hb5s.text(value)],
          action: function (item) {
            if (collapsable) {
              var comp = memMenuThunk().get(item);
              TieredMenu.collapseMenu(comp);
            }
          }
        }),
        {
          dom: {
            tag: 'div',
            classes: [$_30duqlz1jcq8haoh.resolve('styles-menu-items-container')]
          },
          components: [Menu.parts().items({})],
          behaviours: $_bfiithw4jcq8ha84.derive([$_f3aums11sjcq8hb1v.config('adhoc-scrollable-menu', [
              $_dkbc99w6jcq8ha8p.runOnAttached(function (component, simulatedEvent) {
                $_bljwzsjcq8har2.set(component.element(), 'overflow-y', 'auto');
                $_bljwzsjcq8har2.set(component.element(), '-webkit-overflow-scrolling', 'touch');
                $_8r8euk13hjcq8hbbx.register(component.element());
              }),
              $_dkbc99w6jcq8ha8p.runOnDetached(function (component) {
                $_bljwzsjcq8har2.remove(component.element(), 'overflow-y');
                $_bljwzsjcq8har2.remove(component.element(), '-webkit-overflow-scrolling');
                $_8r8euk13hjcq8hbbx.deregister(component.element());
              })
            ])])
        }
      ],
      items: items,
      menuBehaviours: $_bfiithw4jcq8ha84.derive([Transitioning.config({
          initialState: 'after',
          routes: Transitioning.createTristate('before', 'current', 'after', {
            transition: {
              property: 'transform',
              transitionClass: 'transitioning'
            }
          })
        })])
    };
  };
  var sketch$9 = function (settings) {
    var dataset = convert$1(settings.formats, function () {
      return memMenu;
    });
    var memMenu = $_4sw8ie11ejcq8hb07.record(TieredMenu.sketch({
      dom: {
        tag: 'div',
        classes: [$_30duqlz1jcq8haoh.resolve('styles-menu')]
      },
      components: [],
      fakeFocus: true,
      stayInDom: true,
      onExecute: function (tmenu, item) {
        var v = me.getValue(item);
        settings.handle(item, v.value);
      },
      onEscape: function () {
      },
      onOpenMenu: function (container, menu) {
        var w = $_72au9u117jcq8hazb.get(container.element());
        $_72au9u117jcq8hazb.set(menu.element(), w);
        Transitioning.jumpTo(menu, 'current');
      },
      onOpenSubmenu: function (container, item, submenu) {
        var w = $_72au9u117jcq8hazb.get(container.element());
        var menu = $_9rnmwhzmjcq8haqn.ancestor(item.element(), '[role="menu"]').getOrDie('hacky');
        var menuComp = container.getSystem().getByDom(menu).getOrDie();
        $_72au9u117jcq8hazb.set(submenu.element(), w);
        Transitioning.progressTo(menuComp, 'before');
        Transitioning.jumpTo(submenu, 'after');
        Transitioning.progressTo(submenu, 'current');
      },
      onCollapseMenu: function (container, item, menu) {
        var submenu = $_9rnmwhzmjcq8haqn.ancestor(item.element(), '[role="menu"]').getOrDie('hacky');
        var submenuComp = container.getSystem().getByDom(submenu).getOrDie();
        Transitioning.progressTo(submenuComp, 'after');
        Transitioning.progressTo(menu, 'current');
      },
      navigateOnHover: false,
      openImmediately: true,
      data: dataset.tmenu,
      markers: {
        backgroundMenu: $_30duqlz1jcq8haoh.resolve('styles-background-menu'),
        menu: $_30duqlz1jcq8haoh.resolve('styles-menu'),
        selectedMenu: $_30duqlz1jcq8haoh.resolve('styles-selected-menu'),
        item: $_30duqlz1jcq8haoh.resolve('styles-item'),
        selectedItem: $_30duqlz1jcq8haoh.resolve('styles-selected-item')
      }
    }));
    return memMenu.asSpec();
  };
  var $_c992mr12fjcq8hb4r = { sketch: sketch$9 };

  var getFromExpandingItem = function (item) {
    var newItem = $_936c00wyjcq8hab3.deepMerge($_f2tmkex6jcq8hach.exclude(item, ['items']), { menu: true });
    var rest = expand(item.items);
    var newMenus = $_936c00wyjcq8hab3.deepMerge(rest.menus, $_f2tmkex6jcq8hach.wrap(item.title, rest.items));
    var newExpansions = $_936c00wyjcq8hab3.deepMerge(rest.expansions, $_f2tmkex6jcq8hach.wrap(item.title, item.title));
    return {
      item: newItem,
      menus: newMenus,
      expansions: newExpansions
    };
  };
  var getFromItem = function (item) {
    return $_f2tmkex6jcq8hach.hasKey(item, 'items') ? getFromExpandingItem(item) : {
      item: item,
      menus: {},
      expansions: {}
    };
  };
  var expand = function (items) {
    return $_dojsh2w9jcq8ha93.foldr(items, function (acc, item) {
      var newData = getFromItem(item);
      return {
        menus: $_936c00wyjcq8hab3.deepMerge(acc.menus, newData.menus),
        items: [newData.item].concat(acc.items),
        expansions: $_936c00wyjcq8hab3.deepMerge(acc.expansions, newData.expansions)
      };
    }, {
      menus: {},
      expansions: {},
      items: []
    });
  };
  var $_61xyvl13ijcq8hbc0 = { expand: expand };

  var register = function (editor, settings) {
    var isSelectedFor = function (format) {
      return function () {
        return editor.formatter.match(format);
      };
    };
    var getPreview = function (format) {
      return function () {
        var styles = editor.formatter.getCssText(format);
        return styles;
      };
    };
    var enrichSupported = function (item) {
      return $_936c00wyjcq8hab3.deepMerge(item, {
        isSelected: isSelectedFor(item.format),
        getPreview: getPreview(item.format)
      });
    };
    var enrichMenu = function (item) {
      return $_936c00wyjcq8hab3.deepMerge(item, {
        isSelected: $_dh3z58wbjcq8ha9h.constant(false),
        getPreview: $_dh3z58wbjcq8ha9h.constant('')
      });
    };
    var enrichCustom = function (item) {
      var formatName = $_8zlm8d10gjcq8hauo.generate(item.title);
      var newItem = $_936c00wyjcq8hab3.deepMerge(item, {
        format: formatName,
        isSelected: isSelectedFor(formatName),
        getPreview: getPreview(formatName)
      });
      editor.formatter.register(formatName, newItem);
      return newItem;
    };
    var formats = $_f2tmkex6jcq8hach.readOptFrom(settings, 'style_formats').getOr(DefaultStyleFormats);
    var doEnrich = function (items) {
      return $_dojsh2w9jcq8ha93.map(items, function (item) {
        if ($_f2tmkex6jcq8hach.hasKey(item, 'items')) {
          var newItems = doEnrich(item.items);
          return $_936c00wyjcq8hab3.deepMerge(enrichMenu(item), { items: newItems });
        } else if ($_f2tmkex6jcq8hach.hasKey(item, 'format')) {
          return enrichSupported(item);
        } else {
          return enrichCustom(item);
        }
      });
    };
    return doEnrich(formats);
  };
  var prune = function (editor, formats) {
    var doPrune = function (items) {
      return $_dojsh2w9jcq8ha93.bind(items, function (item) {
        if (item.items !== undefined) {
          var newItems = doPrune(item.items);
          return newItems.length > 0 ? [item] : [];
        } else {
          var keep = $_f2tmkex6jcq8hach.hasKey(item, 'format') ? editor.formatter.canApply(item.format) : true;
          return keep ? [item] : [];
        }
      });
    };
    var prunedItems = doPrune(formats);
    return $_61xyvl13ijcq8hbc0.expand(prunedItems);
  };
  var ui = function (editor, formats, onDone) {
    var pruned = prune(editor, formats);
    return $_c992mr12fjcq8hb4r.sketch({
      formats: pruned,
      handle: function (item, value) {
        editor.undoManager.transact(function () {
          if (Toggling.isOn(item)) {
            editor.formatter.remove(value);
          } else {
            editor.formatter.apply(value);
          }
        });
        onDone();
      }
    });
  };
  var $_9vbrue12djcq8hb4i = {
    register: register,
    ui: ui
  };

  var defaults = [
    'undo',
    'bold',
    'italic',
    'link',
    'image',
    'bullist',
    'styleselect'
  ];
  var extract$1 = function (rawToolbar) {
    var toolbar = rawToolbar.replace(/\|/g, ' ').trim();
    return toolbar.length > 0 ? toolbar.split(/\s+/) : [];
  };
  var identifyFromArray = function (toolbar) {
    return $_dojsh2w9jcq8ha93.bind(toolbar, function (item) {
      return $_6xn7hbwzjcq8hab5.isArray(item) ? identifyFromArray(item) : extract$1(item);
    });
  };
  var identify = function (settings) {
    var toolbar = settings.toolbar !== undefined ? settings.toolbar : defaults;
    return $_6xn7hbwzjcq8hab5.isArray(toolbar) ? identifyFromArray(toolbar) : extract$1(toolbar);
  };
  var setup = function (realm, editor) {
    var commandSketch = function (name) {
      return function () {
        return $_378a61z2jcq8haoj.forToolbarCommand(editor, name);
      };
    };
    var stateCommandSketch = function (name) {
      return function () {
        return $_378a61z2jcq8haoj.forToolbarStateCommand(editor, name);
      };
    };
    var actionSketch = function (name, query, action) {
      return function () {
        return $_378a61z2jcq8haoj.forToolbarStateAction(editor, name, query, action);
      };
    };
    var undo = commandSketch('undo');
    var redo = commandSketch('redo');
    var bold = stateCommandSketch('bold');
    var italic = stateCommandSketch('italic');
    var underline = stateCommandSketch('underline');
    var removeformat = commandSketch('removeformat');
    var link = function () {
      return $_91ptrx11ojcq8hb15.sketch(realm, editor);
    };
    var unlink = actionSketch('unlink', 'link', function () {
      editor.execCommand('unlink', null, false);
    });
    var image = function () {
      return $_qik9711djcq8hazz.sketch(editor);
    };
    var bullist = actionSketch('unordered-list', 'ul', function () {
      editor.execCommand('InsertUnorderedList', null, false);
    });
    var numlist = actionSketch('ordered-list', 'ol', function () {
      editor.execCommand('InsertOrderedList', null, false);
    });
    var fontsizeselect = function () {
      return $_e8ilcd119jcq8hazd.sketch(realm, editor);
    };
    var forecolor = function () {
      return $_dy2ywu10sjcq8haxa.sketch(realm, editor);
    };
    var styleFormats = $_9vbrue12djcq8hb4i.register(editor, editor.settings);
    var styleFormatsMenu = function () {
      return $_9vbrue12djcq8hb4i.ui(editor, styleFormats, function () {
        editor.fire('scrollIntoView');
      });
    };
    var styleselect = function () {
      return $_378a61z2jcq8haoj.forToolbar('style-formats', function (button) {
        editor.fire('toReading');
        realm.dropup().appear(styleFormatsMenu, Toggling.on, button);
      }, $_bfiithw4jcq8ha84.derive([
        Toggling.config({
          toggleClass: $_30duqlz1jcq8haoh.resolve('toolbar-button-selected'),
          toggleOnExecute: false,
          aria: { mode: 'pressed' }
        }),
        Receiving.config({
          channels: $_f2tmkex6jcq8hach.wrapAll([
            $_dnir0tz0jcq8hao8.receive($_94pvbiyojcq8hamj.orientationChanged(), Toggling.off),
            $_dnir0tz0jcq8hao8.receive($_94pvbiyojcq8hamj.dropupDismissed(), Toggling.off)
          ])
        })
      ]));
    };
    var feature = function (prereq, sketch) {
      return {
        isSupported: function () {
          return prereq.forall(function (p) {
            return $_f2tmkex6jcq8hach.hasKey(editor.buttons, p);
          });
        },
        sketch: sketch
      };
    };
    return {
      undo: feature($_9m6n87wajcq8ha9e.none(), undo),
      redo: feature($_9m6n87wajcq8ha9e.none(), redo),
      bold: feature($_9m6n87wajcq8ha9e.none(), bold),
      italic: feature($_9m6n87wajcq8ha9e.none(), italic),
      underline: feature($_9m6n87wajcq8ha9e.none(), underline),
      removeformat: feature($_9m6n87wajcq8ha9e.none(), removeformat),
      link: feature($_9m6n87wajcq8ha9e.none(), link),
      unlink: feature($_9m6n87wajcq8ha9e.none(), unlink),
      image: feature($_9m6n87wajcq8ha9e.none(), image),
      bullist: feature($_9m6n87wajcq8ha9e.some('bullist'), bullist),
      numlist: feature($_9m6n87wajcq8ha9e.some('numlist'), numlist),
      fontsizeselect: feature($_9m6n87wajcq8ha9e.none(), fontsizeselect),
      forecolor: feature($_9m6n87wajcq8ha9e.none(), forecolor),
      styleselect: feature($_9m6n87wajcq8ha9e.none(), styleselect)
    };
  };
  var detect$4 = function (settings, features) {
    var itemNames = identify(settings);
    var present = {};
    return $_dojsh2w9jcq8ha93.bind(itemNames, function (iName) {
      var r = !$_f2tmkex6jcq8hach.hasKey(present, iName) && $_f2tmkex6jcq8hach.hasKey(features, iName) && features[iName].isSupported() ? [features[iName].sketch()] : [];
      present[iName] = true;
      return r;
    });
  };
  var $_6ouiyjypjcq8hams = {
    identify: identify,
    setup: setup,
    detect: detect$4
  };

  var mkEvent = function (target, x, y, stop, prevent, kill, raw) {
    return {
      'target': $_dh3z58wbjcq8ha9h.constant(target),
      'x': $_dh3z58wbjcq8ha9h.constant(x),
      'y': $_dh3z58wbjcq8ha9h.constant(y),
      'stop': stop,
      'prevent': prevent,
      'kill': kill,
      'raw': $_dh3z58wbjcq8ha9h.constant(raw)
    };
  };
  var handle = function (filter, handler) {
    return function (rawEvent) {
      if (!filter(rawEvent))
        return;
      var target = $_1t8d5wwtjcq8haao.fromDom(rawEvent.target);
      var stop = function () {
        rawEvent.stopPropagation();
      };
      var prevent = function () {
        rawEvent.preventDefault();
      };
      var kill = $_dh3z58wbjcq8ha9h.compose(prevent, stop);
      var evt = mkEvent(target, rawEvent.clientX, rawEvent.clientY, stop, prevent, kill, rawEvent);
      handler(evt);
    };
  };
  var binder = function (element, event, filter, handler, useCapture) {
    var wrapped = handle(filter, handler);
    element.dom().addEventListener(event, wrapped, useCapture);
    return { unbind: $_dh3z58wbjcq8ha9h.curry(unbind, element, event, wrapped, useCapture) };
  };
  var bind$2 = function (element, event, filter, handler) {
    return binder(element, event, filter, handler, false);
  };
  var capture$1 = function (element, event, filter, handler) {
    return binder(element, event, filter, handler, true);
  };
  var unbind = function (element, event, handler, useCapture) {
    element.dom().removeEventListener(event, handler, useCapture);
  };
  var $_b9fucg13ljcq8hbcc = {
    bind: bind$2,
    capture: capture$1
  };

  var filter$1 = $_dh3z58wbjcq8ha9h.constant(true);
  var bind$1 = function (element, event, handler) {
    return $_b9fucg13ljcq8hbcc.bind(element, event, filter$1, handler);
  };
  var capture = function (element, event, handler) {
    return $_b9fucg13ljcq8hbcc.capture(element, event, filter$1, handler);
  };
  var $_6s2oti13kjcq8hbca = {
    bind: bind$1,
    capture: capture
  };

  var INTERVAL = 50;
  var INSURANCE = 1000 / INTERVAL;
  var get$11 = function (outerWindow) {
    var isPortrait = outerWindow.matchMedia('(orientation: portrait)').matches;
    return { isPortrait: $_dh3z58wbjcq8ha9h.constant(isPortrait) };
  };
  var getActualWidth = function (outerWindow) {
    var isIos = $_6a5cn8wgjcq8ha9o.detect().os.isiOS();
    var isPortrait = get$11(outerWindow).isPortrait();
    return isIos && !isPortrait ? outerWindow.screen.height : outerWindow.screen.width;
  };
  var onChange = function (outerWindow, listeners) {
    var win = $_1t8d5wwtjcq8haao.fromDom(outerWindow);
    var poller = null;
    var change = function () {
      clearInterval(poller);
      var orientation = get$11(outerWindow);
      listeners.onChange(orientation);
      onAdjustment(function () {
        listeners.onReady(orientation);
      });
    };
    var orientationHandle = $_6s2oti13kjcq8hbca.bind(win, 'orientationchange', change);
    var onAdjustment = function (f) {
      clearInterval(poller);
      var flag = outerWindow.innerHeight;
      var insurance = 0;
      poller = setInterval(function () {
        if (flag !== outerWindow.innerHeight) {
          clearInterval(poller);
          f($_9m6n87wajcq8ha9e.some(outerWindow.innerHeight));
        } else if (insurance > INSURANCE) {
          clearInterval(poller);
          f($_9m6n87wajcq8ha9e.none());
        }
        insurance++;
      }, INTERVAL);
    };
    var destroy = function () {
      orientationHandle.unbind();
    };
    return {
      onAdjustment: onAdjustment,
      destroy: destroy
    };
  };
  var $_fxqkqq13jjcq8hbc4 = {
    get: get$11,
    onChange: onChange,
    getActualWidth: getActualWidth
  };

  var DelayedFunction = function (fun, delay) {
    var ref = null;
    var schedule = function () {
      var args = arguments;
      ref = setTimeout(function () {
        fun.apply(null, args);
        ref = null;
      }, delay);
    };
    var cancel = function () {
      if (ref !== null) {
        clearTimeout(ref);
        ref = null;
      }
    };
    return {
      cancel: cancel,
      schedule: schedule
    };
  };

  var SIGNIFICANT_MOVE = 5;
  var LONGPRESS_DELAY = 400;
  var getTouch = function (event) {
    if (event.raw().touches === undefined || event.raw().touches.length !== 1)
      return $_9m6n87wajcq8ha9e.none();
    return $_9m6n87wajcq8ha9e.some(event.raw().touches[0]);
  };
  var isFarEnough = function (touch, data) {
    var distX = Math.abs(touch.clientX - data.x());
    var distY = Math.abs(touch.clientY - data.y());
    return distX > SIGNIFICANT_MOVE || distY > SIGNIFICANT_MOVE;
  };
  var monitor$1 = function (settings) {
    var startData = Cell($_9m6n87wajcq8ha9e.none());
    var longpress = DelayedFunction(function (event) {
      startData.set($_9m6n87wajcq8ha9e.none());
      settings.triggerEvent($_51ilu1wwjcq8haax.longpress(), event);
    }, LONGPRESS_DELAY);
    var handleTouchstart = function (event) {
      getTouch(event).each(function (touch) {
        longpress.cancel();
        var data = {
          x: $_dh3z58wbjcq8ha9h.constant(touch.clientX),
          y: $_dh3z58wbjcq8ha9h.constant(touch.clientY),
          target: event.target
        };
        longpress.schedule(data);
        startData.set($_9m6n87wajcq8ha9e.some(data));
      });
      return $_9m6n87wajcq8ha9e.none();
    };
    var handleTouchmove = function (event) {
      longpress.cancel();
      getTouch(event).each(function (touch) {
        startData.get().each(function (data) {
          if (isFarEnough(touch, data))
            startData.set($_9m6n87wajcq8ha9e.none());
        });
      });
      return $_9m6n87wajcq8ha9e.none();
    };
    var handleTouchend = function (event) {
      longpress.cancel();
      var isSame = function (data) {
        return $_darej4w8jcq8ha8v.eq(data.target(), event.target());
      };
      return startData.get().filter(isSame).map(function (data) {
        return settings.triggerEvent($_51ilu1wwjcq8haax.tap(), event);
      });
    };
    var handlers = $_f2tmkex6jcq8hach.wrapAll([
      {
        key: $_gcr2umwxjcq8hab1.touchstart(),
        value: handleTouchstart
      },
      {
        key: $_gcr2umwxjcq8hab1.touchmove(),
        value: handleTouchmove
      },
      {
        key: $_gcr2umwxjcq8hab1.touchend(),
        value: handleTouchend
      }
    ]);
    var fireIfReady = function (event, type) {
      return $_f2tmkex6jcq8hach.readOptFrom(handlers, type).bind(function (handler) {
        return handler(event);
      });
    };
    return { fireIfReady: fireIfReady };
  };
  var $_29zxna13rjcq8hbde = { monitor: monitor$1 };

  var monitor = function (editorApi) {
    var tapEvent = $_29zxna13rjcq8hbde.monitor({
      triggerEvent: function (type, evt) {
        editorApi.onTapContent(evt);
      }
    });
    var onTouchend = function () {
      return $_6s2oti13kjcq8hbca.bind(editorApi.body(), 'touchend', function (evt) {
        tapEvent.fireIfReady(evt, 'touchend');
      });
    };
    var onTouchmove = function () {
      return $_6s2oti13kjcq8hbca.bind(editorApi.body(), 'touchmove', function (evt) {
        tapEvent.fireIfReady(evt, 'touchmove');
      });
    };
    var fireTouchstart = function (evt) {
      tapEvent.fireIfReady(evt, 'touchstart');
    };
    return {
      fireTouchstart: fireTouchstart,
      onTouchend: onTouchend,
      onTouchmove: onTouchmove
    };
  };
  var $_6osijo13qjcq8hbdc = { monitor: monitor };

  var isAndroid6 = $_6a5cn8wgjcq8ha9o.detect().os.version.major >= 6;
  var initEvents = function (editorApi, toolstrip, alloy) {
    var tapping = $_6osijo13qjcq8hbdc.monitor(editorApi);
    var outerDoc = $_4h5j2xy3jcq8hakl.owner(toolstrip);
    var isRanged = function (sel) {
      return !$_darej4w8jcq8ha8v.eq(sel.start(), sel.finish()) || sel.soffset() !== sel.foffset();
    };
    var hasRangeInUi = function () {
      return $_dgsby1ygjcq8ham1.active(outerDoc).filter(function (input) {
        return $_4z03v7xxjcq8hak1.name(input) === 'input';
      }).exists(function (input) {
        return input.dom().selectionStart !== input.dom().selectionEnd;
      });
    };
    var updateMargin = function () {
      var rangeInContent = editorApi.doc().dom().hasFocus() && editorApi.getSelection().exists(isRanged);
      alloy.getByDom(toolstrip).each((rangeInContent || hasRangeInUi()) === true ? Toggling.on : Toggling.off);
    };
    var listeners = [
      $_6s2oti13kjcq8hbca.bind(editorApi.body(), 'touchstart', function (evt) {
        editorApi.onTouchContent();
        tapping.fireTouchstart(evt);
      }),
      tapping.onTouchmove(),
      tapping.onTouchend(),
      $_6s2oti13kjcq8hbca.bind(toolstrip, 'touchstart', function (evt) {
        editorApi.onTouchToolstrip();
      }),
      editorApi.onToReading(function () {
        $_dgsby1ygjcq8ham1.blur(editorApi.body());
      }),
      editorApi.onToEditing($_dh3z58wbjcq8ha9h.noop),
      editorApi.onScrollToCursor(function (tinyEvent) {
        tinyEvent.preventDefault();
        editorApi.getCursorBox().each(function (bounds) {
          var cWin = editorApi.win();
          var isOutside = bounds.top() > cWin.innerHeight || bounds.bottom() > cWin.innerHeight;
          var cScrollBy = isOutside ? bounds.bottom() - cWin.innerHeight + 50 : 0;
          if (cScrollBy !== 0) {
            cWin.scrollTo(cWin.pageXOffset, cWin.pageYOffset + cScrollBy);
          }
        });
      })
    ].concat(isAndroid6 === true ? [] : [
      $_6s2oti13kjcq8hbca.bind($_1t8d5wwtjcq8haao.fromDom(editorApi.win()), 'blur', function () {
        alloy.getByDom(toolstrip).each(Toggling.off);
      }),
      $_6s2oti13kjcq8hbca.bind(outerDoc, 'select', updateMargin),
      $_6s2oti13kjcq8hbca.bind(editorApi.doc(), 'selectionchange', updateMargin)
    ]);
    var destroy = function () {
      $_dojsh2w9jcq8ha93.each(listeners, function (l) {
        l.unbind();
      });
    };
    return { destroy: destroy };
  };
  var $_9cvp4j13pjcq8hbd1 = { initEvents: initEvents };

  var autocompleteHack = function () {
    return function (f) {
      setTimeout(function () {
        f();
      }, 0);
    };
  };
  var resume = function (cWin) {
    cWin.focus();
    var iBody = $_1t8d5wwtjcq8haao.fromDom(cWin.document.body);
    var inInput = $_dgsby1ygjcq8ham1.active().exists(function (elem) {
      return $_dojsh2w9jcq8ha93.contains([
        'input',
        'textarea'
      ], $_4z03v7xxjcq8hak1.name(elem));
    });
    var transaction = inInput ? autocompleteHack() : $_dh3z58wbjcq8ha9h.apply;
    transaction(function () {
      $_dgsby1ygjcq8ham1.active().each($_dgsby1ygjcq8ham1.blur);
      $_dgsby1ygjcq8ham1.focus(iBody);
    });
  };
  var $_7jkgw313ujcq8hbdu = { resume: resume };

  var safeParse = function (element, attribute) {
    var parsed = parseInt($_3kyqh4xwjcq8hajw.get(element, attribute), 10);
    return isNaN(parsed) ? 0 : parsed;
  };
  var $_91010l13vjcq8hbdz = { safeParse: safeParse };

  var NodeValue = function (is, name) {
    var get = function (element) {
      if (!is(element))
        throw new Error('Can only get ' + name + ' value of a ' + name + ' node');
      return getOption(element).getOr('');
    };
    var getOptionIE10 = function (element) {
      try {
        return getOptionSafe(element);
      } catch (e) {
        return $_9m6n87wajcq8ha9e.none();
      }
    };
    var getOptionSafe = function (element) {
      return is(element) ? $_9m6n87wajcq8ha9e.from(element.dom().nodeValue) : $_9m6n87wajcq8ha9e.none();
    };
    var browser = $_6a5cn8wgjcq8ha9o.detect().browser;
    var getOption = browser.isIE() && browser.version.major === 10 ? getOptionIE10 : getOptionSafe;
    var set = function (element, value) {
      if (!is(element))
        throw new Error('Can only set raw ' + name + ' value of a ' + name + ' node');
      element.dom().nodeValue = value;
    };
    return {
      get: get,
      getOption: getOption,
      set: set
    };
  };

  var api$3 = NodeValue($_4z03v7xxjcq8hak1.isText, 'text');
  var get$12 = function (element) {
    return api$3.get(element);
  };
  var getOption = function (element) {
    return api$3.getOption(element);
  };
  var set$8 = function (element, value) {
    api$3.set(element, value);
  };
  var $_4o0fcu13yjcq8hbea = {
    get: get$12,
    getOption: getOption,
    set: set$8
  };

  var getEnd = function (element) {
    return $_4z03v7xxjcq8hak1.name(element) === 'img' ? 1 : $_4o0fcu13yjcq8hbea.getOption(element).fold(function () {
      return $_4h5j2xy3jcq8hakl.children(element).length;
    }, function (v) {
      return v.length;
    });
  };
  var isEnd = function (element, offset) {
    return getEnd(element) === offset;
  };
  var isStart = function (element, offset) {
    return offset === 0;
  };
  var NBSP = '\xA0';
  var isTextNodeWithCursorPosition = function (el) {
    return $_4o0fcu13yjcq8hbea.getOption(el).filter(function (text) {
      return text.trim().length !== 0 || text.indexOf(NBSP) > -1;
    }).isSome();
  };
  var elementsWithCursorPosition = [
    'img',
    'br'
  ];
  var isCursorPosition = function (elem) {
    var hasCursorPosition = isTextNodeWithCursorPosition(elem);
    return hasCursorPosition || $_dojsh2w9jcq8ha93.contains(elementsWithCursorPosition, $_4z03v7xxjcq8hak1.name(elem));
  };
  var $_a93br13xjcq8hbe8 = {
    getEnd: getEnd,
    isEnd: isEnd,
    isStart: isStart,
    isCursorPosition: isCursorPosition
  };

  var adt$4 = $_dho4a6x4jcq8habz.generate([
    { 'before': ['element'] },
    {
      'on': [
        'element',
        'offset'
      ]
    },
    { after: ['element'] }
  ]);
  var cata = function (subject, onBefore, onOn, onAfter) {
    return subject.fold(onBefore, onOn, onAfter);
  };
  var getStart$1 = function (situ) {
    return situ.fold($_dh3z58wbjcq8ha9h.identity, $_dh3z58wbjcq8ha9h.identity, $_dh3z58wbjcq8ha9h.identity);
  };
  var $_1g4un7141jcq8hbeo = {
    before: adt$4.before,
    on: adt$4.on,
    after: adt$4.after,
    cata: cata,
    getStart: getStart$1
  };

  var type$1 = $_dho4a6x4jcq8habz.generate([
    { domRange: ['rng'] },
    {
      relative: [
        'startSitu',
        'finishSitu'
      ]
    },
    {
      exact: [
        'start',
        'soffset',
        'finish',
        'foffset'
      ]
    }
  ]);
  var range$1 = $_4e5yxhxmjcq8hajd.immutable('start', 'soffset', 'finish', 'foffset');
  var exactFromRange = function (simRange) {
    return type$1.exact(simRange.start(), simRange.soffset(), simRange.finish(), simRange.foffset());
  };
  var getStart = function (selection) {
    return selection.match({
      domRange: function (rng) {
        return $_1t8d5wwtjcq8haao.fromDom(rng.startContainer);
      },
      relative: function (startSitu, finishSitu) {
        return $_1g4un7141jcq8hbeo.getStart(startSitu);
      },
      exact: function (start, soffset, finish, foffset) {
        return start;
      }
    });
  };
  var getWin = function (selection) {
    var start = getStart(selection);
    return $_4h5j2xy3jcq8hakl.defaultView(start);
  };
  var $_eckh3b140jcq8hbef = {
    domRange: type$1.domRange,
    relative: type$1.relative,
    exact: type$1.exact,
    exactFromRange: exactFromRange,
    range: range$1,
    getWin: getWin
  };

  var makeRange = function (start, soffset, finish, foffset) {
    var doc = $_4h5j2xy3jcq8hakl.owner(start);
    var rng = doc.dom().createRange();
    rng.setStart(start.dom(), soffset);
    rng.setEnd(finish.dom(), foffset);
    return rng;
  };
  var commonAncestorContainer = function (start, soffset, finish, foffset) {
    var r = makeRange(start, soffset, finish, foffset);
    return $_1t8d5wwtjcq8haao.fromDom(r.commonAncestorContainer);
  };
  var after$2 = function (start, soffset, finish, foffset) {
    var r = makeRange(start, soffset, finish, foffset);
    var same = $_darej4w8jcq8ha8v.eq(start, finish) && soffset === foffset;
    return r.collapsed && !same;
  };
  var $_edpj3c143jcq8hbew = {
    after: after$2,
    commonAncestorContainer: commonAncestorContainer
  };

  var fromElements = function (elements, scope) {
    var doc = scope || document;
    var fragment = doc.createDocumentFragment();
    $_dojsh2w9jcq8ha93.each(elements, function (element) {
      fragment.appendChild(element.dom());
    });
    return $_1t8d5wwtjcq8haao.fromDom(fragment);
  };
  var $_bpvq3u144jcq8hbex = { fromElements: fromElements };

  var selectNodeContents = function (win, element) {
    var rng = win.document.createRange();
    selectNodeContentsUsing(rng, element);
    return rng;
  };
  var selectNodeContentsUsing = function (rng, element) {
    rng.selectNodeContents(element.dom());
  };
  var isWithin = function (outerRange, innerRange) {
    return innerRange.compareBoundaryPoints(outerRange.END_TO_START, outerRange) < 1 && innerRange.compareBoundaryPoints(outerRange.START_TO_END, outerRange) > -1;
  };
  var create$5 = function (win) {
    return win.document.createRange();
  };
  var setStart = function (rng, situ) {
    situ.fold(function (e) {
      rng.setStartBefore(e.dom());
    }, function (e, o) {
      rng.setStart(e.dom(), o);
    }, function (e) {
      rng.setStartAfter(e.dom());
    });
  };
  var setFinish = function (rng, situ) {
    situ.fold(function (e) {
      rng.setEndBefore(e.dom());
    }, function (e, o) {
      rng.setEnd(e.dom(), o);
    }, function (e) {
      rng.setEndAfter(e.dom());
    });
  };
  var replaceWith = function (rng, fragment) {
    deleteContents(rng);
    rng.insertNode(fragment.dom());
  };
  var relativeToNative = function (win, startSitu, finishSitu) {
    var range = win.document.createRange();
    setStart(range, startSitu);
    setFinish(range, finishSitu);
    return range;
  };
  var exactToNative = function (win, start, soffset, finish, foffset) {
    var rng = win.document.createRange();
    rng.setStart(start.dom(), soffset);
    rng.setEnd(finish.dom(), foffset);
    return rng;
  };
  var deleteContents = function (rng) {
    rng.deleteContents();
  };
  var cloneFragment = function (rng) {
    var fragment = rng.cloneContents();
    return $_1t8d5wwtjcq8haao.fromDom(fragment);
  };
  var toRect$1 = function (rect) {
    return {
      left: $_dh3z58wbjcq8ha9h.constant(rect.left),
      top: $_dh3z58wbjcq8ha9h.constant(rect.top),
      right: $_dh3z58wbjcq8ha9h.constant(rect.right),
      bottom: $_dh3z58wbjcq8ha9h.constant(rect.bottom),
      width: $_dh3z58wbjcq8ha9h.constant(rect.width),
      height: $_dh3z58wbjcq8ha9h.constant(rect.height)
    };
  };
  var getFirstRect$1 = function (rng) {
    var rects = rng.getClientRects();
    var rect = rects.length > 0 ? rects[0] : rng.getBoundingClientRect();
    return rect.width > 0 || rect.height > 0 ? $_9m6n87wajcq8ha9e.some(rect).map(toRect$1) : $_9m6n87wajcq8ha9e.none();
  };
  var getBounds$2 = function (rng) {
    var rect = rng.getBoundingClientRect();
    return rect.width > 0 || rect.height > 0 ? $_9m6n87wajcq8ha9e.some(rect).map(toRect$1) : $_9m6n87wajcq8ha9e.none();
  };
  var toString$1 = function (rng) {
    return rng.toString();
  };
  var $_8ly6o1145jcq8hbf0 = {
    create: create$5,
    replaceWith: replaceWith,
    selectNodeContents: selectNodeContents,
    selectNodeContentsUsing: selectNodeContentsUsing,
    relativeToNative: relativeToNative,
    exactToNative: exactToNative,
    deleteContents: deleteContents,
    cloneFragment: cloneFragment,
    getFirstRect: getFirstRect$1,
    getBounds: getBounds$2,
    isWithin: isWithin,
    toString: toString$1
  };

  var adt$5 = $_dho4a6x4jcq8habz.generate([
    {
      ltr: [
        'start',
        'soffset',
        'finish',
        'foffset'
      ]
    },
    {
      rtl: [
        'start',
        'soffset',
        'finish',
        'foffset'
      ]
    }
  ]);
  var fromRange = function (win, type, range) {
    return type($_1t8d5wwtjcq8haao.fromDom(range.startContainer), range.startOffset, $_1t8d5wwtjcq8haao.fromDom(range.endContainer), range.endOffset);
  };
  var getRanges = function (win, selection) {
    return selection.match({
      domRange: function (rng) {
        return {
          ltr: $_dh3z58wbjcq8ha9h.constant(rng),
          rtl: $_9m6n87wajcq8ha9e.none
        };
      },
      relative: function (startSitu, finishSitu) {
        return {
          ltr: $_8mt73whjcq8ha9q.cached(function () {
            return $_8ly6o1145jcq8hbf0.relativeToNative(win, startSitu, finishSitu);
          }),
          rtl: $_8mt73whjcq8ha9q.cached(function () {
            return $_9m6n87wajcq8ha9e.some($_8ly6o1145jcq8hbf0.relativeToNative(win, finishSitu, startSitu));
          })
        };
      },
      exact: function (start, soffset, finish, foffset) {
        return {
          ltr: $_8mt73whjcq8ha9q.cached(function () {
            return $_8ly6o1145jcq8hbf0.exactToNative(win, start, soffset, finish, foffset);
          }),
          rtl: $_8mt73whjcq8ha9q.cached(function () {
            return $_9m6n87wajcq8ha9e.some($_8ly6o1145jcq8hbf0.exactToNative(win, finish, foffset, start, soffset));
          })
        };
      }
    });
  };
  var doDiagnose = function (win, ranges) {
    var rng = ranges.ltr();
    if (rng.collapsed) {
      var reversed = ranges.rtl().filter(function (rev) {
        return rev.collapsed === false;
      });
      return reversed.map(function (rev) {
        return adt$5.rtl($_1t8d5wwtjcq8haao.fromDom(rev.endContainer), rev.endOffset, $_1t8d5wwtjcq8haao.fromDom(rev.startContainer), rev.startOffset);
      }).getOrThunk(function () {
        return fromRange(win, adt$5.ltr, rng);
      });
    } else {
      return fromRange(win, adt$5.ltr, rng);
    }
  };
  var diagnose = function (win, selection) {
    var ranges = getRanges(win, selection);
    return doDiagnose(win, ranges);
  };
  var asLtrRange = function (win, selection) {
    var diagnosis = diagnose(win, selection);
    return diagnosis.match({
      ltr: function (start, soffset, finish, foffset) {
        var rng = win.document.createRange();
        rng.setStart(start.dom(), soffset);
        rng.setEnd(finish.dom(), foffset);
        return rng;
      },
      rtl: function (start, soffset, finish, foffset) {
        var rng = win.document.createRange();
        rng.setStart(finish.dom(), foffset);
        rng.setEnd(start.dom(), soffset);
        return rng;
      }
    });
  };
  var $_6d1uk3146jcq8hbf5 = {
    ltr: adt$5.ltr,
    rtl: adt$5.rtl,
    diagnose: diagnose,
    asLtrRange: asLtrRange
  };

  var searchForPoint = function (rectForOffset, x, y, maxX, length) {
    if (length === 0)
      return 0;
    else if (x === maxX)
      return length - 1;
    var xDelta = maxX;
    for (var i = 1; i < length; i++) {
      var rect = rectForOffset(i);
      var curDeltaX = Math.abs(x - rect.left);
      if (y > rect.bottom) {
      } else if (y < rect.top || curDeltaX > xDelta) {
        return i - 1;
      } else {
        xDelta = curDeltaX;
      }
    }
    return 0;
  };
  var inRect = function (rect, x, y) {
    return x >= rect.left && x <= rect.right && y >= rect.top && y <= rect.bottom;
  };
  var $_cvhx5v149jcq8hbfj = {
    inRect: inRect,
    searchForPoint: searchForPoint
  };

  var locateOffset = function (doc, textnode, x, y, rect) {
    var rangeForOffset = function (offset) {
      var r = doc.dom().createRange();
      r.setStart(textnode.dom(), offset);
      r.collapse(true);
      return r;
    };
    var rectForOffset = function (offset) {
      var r = rangeForOffset(offset);
      return r.getBoundingClientRect();
    };
    var length = $_4o0fcu13yjcq8hbea.get(textnode).length;
    var offset = $_cvhx5v149jcq8hbfj.searchForPoint(rectForOffset, x, y, rect.right, length);
    return rangeForOffset(offset);
  };
  var locate$2 = function (doc, node, x, y) {
    var r = doc.dom().createRange();
    r.selectNode(node.dom());
    var rects = r.getClientRects();
    var foundRect = $_4d7j4zyejcq8halz.findMap(rects, function (rect) {
      return $_cvhx5v149jcq8hbfj.inRect(rect, x, y) ? $_9m6n87wajcq8ha9e.some(rect) : $_9m6n87wajcq8ha9e.none();
    });
    return foundRect.map(function (rect) {
      return locateOffset(doc, node, x, y, rect);
    });
  };
  var $_34m0xs14ajcq8hbfk = { locate: locate$2 };

  var searchInChildren = function (doc, node, x, y) {
    var r = doc.dom().createRange();
    var nodes = $_4h5j2xy3jcq8hakl.children(node);
    return $_4d7j4zyejcq8halz.findMap(nodes, function (n) {
      r.selectNode(n.dom());
      return $_cvhx5v149jcq8hbfj.inRect(r.getBoundingClientRect(), x, y) ? locateNode(doc, n, x, y) : $_9m6n87wajcq8ha9e.none();
    });
  };
  var locateNode = function (doc, node, x, y) {
    var locator = $_4z03v7xxjcq8hak1.isText(node) ? $_34m0xs14ajcq8hbfk.locate : searchInChildren;
    return locator(doc, node, x, y);
  };
  var locate$1 = function (doc, node, x, y) {
    var r = doc.dom().createRange();
    r.selectNode(node.dom());
    var rect = r.getBoundingClientRect();
    var boundedX = Math.max(rect.left, Math.min(rect.right, x));
    var boundedY = Math.max(rect.top, Math.min(rect.bottom, y));
    return locateNode(doc, node, boundedX, boundedY);
  };
  var $_9u7wka148jcq8hbff = { locate: locate$1 };

  var first$3 = function (element) {
    return $_1vm5o1yijcq8ham7.descendant(element, $_a93br13xjcq8hbe8.isCursorPosition);
  };
  var last$2 = function (element) {
    return descendantRtl(element, $_a93br13xjcq8hbe8.isCursorPosition);
  };
  var descendantRtl = function (scope, predicate) {
    var descend = function (element) {
      var children = $_4h5j2xy3jcq8hakl.children(element);
      for (var i = children.length - 1; i >= 0; i--) {
        var child = children[i];
        if (predicate(child))
          return $_9m6n87wajcq8ha9e.some(child);
        var res = descend(child);
        if (res.isSome())
          return res;
      }
      return $_9m6n87wajcq8ha9e.none();
    };
    return descend(scope);
  };
  var $_7exr4a14cjcq8hbfq = {
    first: first$3,
    last: last$2
  };

  var COLLAPSE_TO_LEFT = true;
  var COLLAPSE_TO_RIGHT = false;
  var getCollapseDirection = function (rect, x) {
    return x - rect.left < rect.right - x ? COLLAPSE_TO_LEFT : COLLAPSE_TO_RIGHT;
  };
  var createCollapsedNode = function (doc, target, collapseDirection) {
    var r = doc.dom().createRange();
    r.selectNode(target.dom());
    r.collapse(collapseDirection);
    return r;
  };
  var locateInElement = function (doc, node, x) {
    var cursorRange = doc.dom().createRange();
    cursorRange.selectNode(node.dom());
    var rect = cursorRange.getBoundingClientRect();
    var collapseDirection = getCollapseDirection(rect, x);
    var f = collapseDirection === COLLAPSE_TO_LEFT ? $_7exr4a14cjcq8hbfq.first : $_7exr4a14cjcq8hbfq.last;
    return f(node).map(function (target) {
      return createCollapsedNode(doc, target, collapseDirection);
    });
  };
  var locateInEmpty = function (doc, node, x) {
    var rect = node.dom().getBoundingClientRect();
    var collapseDirection = getCollapseDirection(rect, x);
    return $_9m6n87wajcq8ha9e.some(createCollapsedNode(doc, node, collapseDirection));
  };
  var search$1 = function (doc, node, x) {
    var f = $_4h5j2xy3jcq8hakl.children(node).length === 0 ? locateInEmpty : locateInElement;
    return f(doc, node, x);
  };
  var $_8xcxhy14bjcq8hbfo = { search: search$1 };

  var caretPositionFromPoint = function (doc, x, y) {
    return $_9m6n87wajcq8ha9e.from(doc.dom().caretPositionFromPoint(x, y)).bind(function (pos) {
      if (pos.offsetNode === null)
        return $_9m6n87wajcq8ha9e.none();
      var r = doc.dom().createRange();
      r.setStart(pos.offsetNode, pos.offset);
      r.collapse();
      return $_9m6n87wajcq8ha9e.some(r);
    });
  };
  var caretRangeFromPoint = function (doc, x, y) {
    return $_9m6n87wajcq8ha9e.from(doc.dom().caretRangeFromPoint(x, y));
  };
  var searchTextNodes = function (doc, node, x, y) {
    var r = doc.dom().createRange();
    r.selectNode(node.dom());
    var rect = r.getBoundingClientRect();
    var boundedX = Math.max(rect.left, Math.min(rect.right, x));
    var boundedY = Math.max(rect.top, Math.min(rect.bottom, y));
    return $_9u7wka148jcq8hbff.locate(doc, node, boundedX, boundedY);
  };
  var searchFromPoint = function (doc, x, y) {
    return $_1t8d5wwtjcq8haao.fromPoint(doc, x, y).bind(function (elem) {
      var fallback = function () {
        return $_8xcxhy14bjcq8hbfo.search(doc, elem, x);
      };
      return $_4h5j2xy3jcq8hakl.children(elem).length === 0 ? fallback() : searchTextNodes(doc, elem, x, y).orThunk(fallback);
    });
  };
  var availableSearch = document.caretPositionFromPoint ? caretPositionFromPoint : document.caretRangeFromPoint ? caretRangeFromPoint : searchFromPoint;
  var fromPoint$1 = function (win, x, y) {
    var doc = $_1t8d5wwtjcq8haao.fromDom(win.document);
    return availableSearch(doc, x, y).map(function (rng) {
      return $_eckh3b140jcq8hbef.range($_1t8d5wwtjcq8haao.fromDom(rng.startContainer), rng.startOffset, $_1t8d5wwtjcq8haao.fromDom(rng.endContainer), rng.endOffset);
    });
  };
  var $_233m82147jcq8hbfc = { fromPoint: fromPoint$1 };

  var withinContainer = function (win, ancestor, outerRange, selector) {
    var innerRange = $_8ly6o1145jcq8hbf0.create(win);
    var self = $_eekfszwsjcq8haak.is(ancestor, selector) ? [ancestor] : [];
    var elements = self.concat($_9rnqqqzkjcq8haqj.descendants(ancestor, selector));
    return $_dojsh2w9jcq8ha93.filter(elements, function (elem) {
      $_8ly6o1145jcq8hbf0.selectNodeContentsUsing(innerRange, elem);
      return $_8ly6o1145jcq8hbf0.isWithin(outerRange, innerRange);
    });
  };
  var find$4 = function (win, selection, selector) {
    var outerRange = $_6d1uk3146jcq8hbf5.asLtrRange(win, selection);
    var ancestor = $_1t8d5wwtjcq8haao.fromDom(outerRange.commonAncestorContainer);
    return $_4z03v7xxjcq8hak1.isElement(ancestor) ? withinContainer(win, ancestor, outerRange, selector) : [];
  };
  var $_5o4b9214djcq8hbfu = { find: find$4 };

  var beforeSpecial = function (element, offset) {
    var name = $_4z03v7xxjcq8hak1.name(element);
    if ('input' === name)
      return $_1g4un7141jcq8hbeo.after(element);
    else if (!$_dojsh2w9jcq8ha93.contains([
        'br',
        'img'
      ], name))
      return $_1g4un7141jcq8hbeo.on(element, offset);
    else
      return offset === 0 ? $_1g4un7141jcq8hbeo.before(element) : $_1g4un7141jcq8hbeo.after(element);
  };
  var preprocessRelative = function (startSitu, finishSitu) {
    var start = startSitu.fold($_1g4un7141jcq8hbeo.before, beforeSpecial, $_1g4un7141jcq8hbeo.after);
    var finish = finishSitu.fold($_1g4un7141jcq8hbeo.before, beforeSpecial, $_1g4un7141jcq8hbeo.after);
    return $_eckh3b140jcq8hbef.relative(start, finish);
  };
  var preprocessExact = function (start, soffset, finish, foffset) {
    var startSitu = beforeSpecial(start, soffset);
    var finishSitu = beforeSpecial(finish, foffset);
    return $_eckh3b140jcq8hbef.relative(startSitu, finishSitu);
  };
  var preprocess = function (selection) {
    return selection.match({
      domRange: function (rng) {
        var start = $_1t8d5wwtjcq8haao.fromDom(rng.startContainer);
        var finish = $_1t8d5wwtjcq8haao.fromDom(rng.endContainer);
        return preprocessExact(start, rng.startOffset, finish, rng.endOffset);
      },
      relative: preprocessRelative,
      exact: preprocessExact
    });
  };
  var $_8azgl014ejcq8hbfx = {
    beforeSpecial: beforeSpecial,
    preprocess: preprocess,
    preprocessRelative: preprocessRelative,
    preprocessExact: preprocessExact
  };

  var doSetNativeRange = function (win, rng) {
    $_9m6n87wajcq8ha9e.from(win.getSelection()).each(function (selection) {
      selection.removeAllRanges();
      selection.addRange(rng);
    });
  };
  var doSetRange = function (win, start, soffset, finish, foffset) {
    var rng = $_8ly6o1145jcq8hbf0.exactToNative(win, start, soffset, finish, foffset);
    doSetNativeRange(win, rng);
  };
  var findWithin = function (win, selection, selector) {
    return $_5o4b9214djcq8hbfu.find(win, selection, selector);
  };
  var setRangeFromRelative = function (win, relative) {
    return $_6d1uk3146jcq8hbf5.diagnose(win, relative).match({
      ltr: function (start, soffset, finish, foffset) {
        doSetRange(win, start, soffset, finish, foffset);
      },
      rtl: function (start, soffset, finish, foffset) {
        var selection = win.getSelection();
        if (selection.extend) {
          selection.collapse(start.dom(), soffset);
          selection.extend(finish.dom(), foffset);
        } else {
          doSetRange(win, finish, foffset, start, soffset);
        }
      }
    });
  };
  var setExact = function (win, start, soffset, finish, foffset) {
    var relative = $_8azgl014ejcq8hbfx.preprocessExact(start, soffset, finish, foffset);
    setRangeFromRelative(win, relative);
  };
  var setRelative = function (win, startSitu, finishSitu) {
    var relative = $_8azgl014ejcq8hbfx.preprocessRelative(startSitu, finishSitu);
    setRangeFromRelative(win, relative);
  };
  var toNative = function (selection) {
    var win = $_eckh3b140jcq8hbef.getWin(selection).dom();
    var getDomRange = function (start, soffset, finish, foffset) {
      return $_8ly6o1145jcq8hbf0.exactToNative(win, start, soffset, finish, foffset);
    };
    var filtered = $_8azgl014ejcq8hbfx.preprocess(selection);
    return $_6d1uk3146jcq8hbf5.diagnose(win, filtered).match({
      ltr: getDomRange,
      rtl: getDomRange
    });
  };
  var readRange = function (selection) {
    if (selection.rangeCount > 0) {
      var firstRng = selection.getRangeAt(0);
      var lastRng = selection.getRangeAt(selection.rangeCount - 1);
      return $_9m6n87wajcq8ha9e.some($_eckh3b140jcq8hbef.range($_1t8d5wwtjcq8haao.fromDom(firstRng.startContainer), firstRng.startOffset, $_1t8d5wwtjcq8haao.fromDom(lastRng.endContainer), lastRng.endOffset));
    } else {
      return $_9m6n87wajcq8ha9e.none();
    }
  };
  var doGetExact = function (selection) {
    var anchorNode = $_1t8d5wwtjcq8haao.fromDom(selection.anchorNode);
    var focusNode = $_1t8d5wwtjcq8haao.fromDom(selection.focusNode);
    return $_edpj3c143jcq8hbew.after(anchorNode, selection.anchorOffset, focusNode, selection.focusOffset) ? $_9m6n87wajcq8ha9e.some($_eckh3b140jcq8hbef.range($_1t8d5wwtjcq8haao.fromDom(selection.anchorNode), selection.anchorOffset, $_1t8d5wwtjcq8haao.fromDom(selection.focusNode), selection.focusOffset)) : readRange(selection);
  };
  var setToElement = function (win, element) {
    var rng = $_8ly6o1145jcq8hbf0.selectNodeContents(win, element);
    doSetNativeRange(win, rng);
  };
  var forElement = function (win, element) {
    var rng = $_8ly6o1145jcq8hbf0.selectNodeContents(win, element);
    return $_eckh3b140jcq8hbef.range($_1t8d5wwtjcq8haao.fromDom(rng.startContainer), rng.startOffset, $_1t8d5wwtjcq8haao.fromDom(rng.endContainer), rng.endOffset);
  };
  var getExact = function (win) {
    var selection = win.getSelection();
    return selection.rangeCount > 0 ? doGetExact(selection) : $_9m6n87wajcq8ha9e.none();
  };
  var get$13 = function (win) {
    return getExact(win).map(function (range) {
      return $_eckh3b140jcq8hbef.exact(range.start(), range.soffset(), range.finish(), range.foffset());
    });
  };
  var getFirstRect = function (win, selection) {
    var rng = $_6d1uk3146jcq8hbf5.asLtrRange(win, selection);
    return $_8ly6o1145jcq8hbf0.getFirstRect(rng);
  };
  var getBounds$1 = function (win, selection) {
    var rng = $_6d1uk3146jcq8hbf5.asLtrRange(win, selection);
    return $_8ly6o1145jcq8hbf0.getBounds(rng);
  };
  var getAtPoint = function (win, x, y) {
    return $_233m82147jcq8hbfc.fromPoint(win, x, y);
  };
  var getAsString = function (win, selection) {
    var rng = $_6d1uk3146jcq8hbf5.asLtrRange(win, selection);
    return $_8ly6o1145jcq8hbf0.toString(rng);
  };
  var clear$1 = function (win) {
    var selection = win.getSelection();
    selection.removeAllRanges();
  };
  var clone$3 = function (win, selection) {
    var rng = $_6d1uk3146jcq8hbf5.asLtrRange(win, selection);
    return $_8ly6o1145jcq8hbf0.cloneFragment(rng);
  };
  var replace = function (win, selection, elements) {
    var rng = $_6d1uk3146jcq8hbf5.asLtrRange(win, selection);
    var fragment = $_bpvq3u144jcq8hbex.fromElements(elements, win.document);
    $_8ly6o1145jcq8hbf0.replaceWith(rng, fragment);
  };
  var deleteAt = function (win, selection) {
    var rng = $_6d1uk3146jcq8hbf5.asLtrRange(win, selection);
    $_8ly6o1145jcq8hbf0.deleteContents(rng);
  };
  var isCollapsed = function (start, soffset, finish, foffset) {
    return $_darej4w8jcq8ha8v.eq(start, finish) && soffset === foffset;
  };
  var $_dkl1yh142jcq8hber = {
    setExact: setExact,
    getExact: getExact,
    get: get$13,
    setRelative: setRelative,
    toNative: toNative,
    setToElement: setToElement,
    clear: clear$1,
    clone: clone$3,
    replace: replace,
    deleteAt: deleteAt,
    forElement: forElement,
    getFirstRect: getFirstRect,
    getBounds: getBounds$1,
    getAtPoint: getAtPoint,
    findWithin: findWithin,
    getAsString: getAsString,
    isCollapsed: isCollapsed
  };

  var COLLAPSED_WIDTH = 2;
  var collapsedRect = function (rect) {
    return {
      left: rect.left,
      top: rect.top,
      right: rect.right,
      bottom: rect.bottom,
      width: $_dh3z58wbjcq8ha9h.constant(COLLAPSED_WIDTH),
      height: rect.height
    };
  };
  var toRect = function (rawRect) {
    return {
      left: $_dh3z58wbjcq8ha9h.constant(rawRect.left),
      top: $_dh3z58wbjcq8ha9h.constant(rawRect.top),
      right: $_dh3z58wbjcq8ha9h.constant(rawRect.right),
      bottom: $_dh3z58wbjcq8ha9h.constant(rawRect.bottom),
      width: $_dh3z58wbjcq8ha9h.constant(rawRect.width),
      height: $_dh3z58wbjcq8ha9h.constant(rawRect.height)
    };
  };
  var getRectsFromRange = function (range) {
    if (!range.collapsed) {
      return $_dojsh2w9jcq8ha93.map(range.getClientRects(), toRect);
    } else {
      var start_1 = $_1t8d5wwtjcq8haao.fromDom(range.startContainer);
      return $_4h5j2xy3jcq8hakl.parent(start_1).bind(function (parent) {
        var selection = $_eckh3b140jcq8hbef.exact(start_1, range.startOffset, parent, $_a93br13xjcq8hbe8.getEnd(parent));
        var optRect = $_dkl1yh142jcq8hber.getFirstRect(range.startContainer.ownerDocument.defaultView, selection);
        return optRect.map(collapsedRect).map($_dojsh2w9jcq8ha93.pure);
      }).getOr([]);
    }
  };
  var getRectangles = function (cWin) {
    var sel = cWin.getSelection();
    return sel !== undefined && sel.rangeCount > 0 ? getRectsFromRange(sel.getRangeAt(0)) : [];
  };
  var $_8y90mv13wjcq8hbe1 = { getRectangles: getRectangles };

  var EXTRA_SPACING = 50;
  var data = 'data-' + $_30duqlz1jcq8haoh.resolve('last-outer-height');
  var setLastHeight = function (cBody, value) {
    $_3kyqh4xwjcq8hajw.set(cBody, data, value);
  };
  var getLastHeight = function (cBody) {
    return $_91010l13vjcq8hbdz.safeParse(cBody, data);
  };
  var getBoundsFrom = function (rect) {
    return {
      top: $_dh3z58wbjcq8ha9h.constant(rect.top()),
      bottom: $_dh3z58wbjcq8ha9h.constant(rect.top() + rect.height())
    };
  };
  var getBounds = function (cWin) {
    var rects = $_8y90mv13wjcq8hbe1.getRectangles(cWin);
    return rects.length > 0 ? $_9m6n87wajcq8ha9e.some(rects[0]).map(getBoundsFrom) : $_9m6n87wajcq8ha9e.none();
  };
  var findDelta = function (outerWindow, cBody) {
    var last = getLastHeight(cBody);
    var current = outerWindow.innerHeight;
    return last > current ? $_9m6n87wajcq8ha9e.some(last - current) : $_9m6n87wajcq8ha9e.none();
  };
  var calculate = function (cWin, bounds, delta) {
    var isOutside = bounds.top() > cWin.innerHeight || bounds.bottom() > cWin.innerHeight;
    return isOutside ? Math.min(delta, bounds.bottom() - cWin.innerHeight + EXTRA_SPACING) : 0;
  };
  var setup$1 = function (outerWindow, cWin) {
    var cBody = $_1t8d5wwtjcq8haao.fromDom(cWin.document.body);
    var toEditing = function () {
      $_7jkgw313ujcq8hbdu.resume(cWin);
    };
    var onResize = $_6s2oti13kjcq8hbca.bind($_1t8d5wwtjcq8haao.fromDom(outerWindow), 'resize', function () {
      findDelta(outerWindow, cBody).each(function (delta) {
        getBounds(cWin).each(function (bounds) {
          var cScrollBy = calculate(cWin, bounds, delta);
          if (cScrollBy !== 0) {
            cWin.scrollTo(cWin.pageXOffset, cWin.pageYOffset + cScrollBy);
          }
        });
      });
      setLastHeight(cBody, outerWindow.innerHeight);
    });
    setLastHeight(cBody, outerWindow.innerHeight);
    var destroy = function () {
      onResize.unbind();
    };
    return {
      toEditing: toEditing,
      destroy: destroy
    };
  };
  var $_afsq9l13tjcq8hbdn = { setup: setup$1 };

  var getBodyFromFrame = function (frame) {
    return $_9m6n87wajcq8ha9e.some($_1t8d5wwtjcq8haao.fromDom(frame.dom().contentWindow.document.body));
  };
  var getDocFromFrame = function (frame) {
    return $_9m6n87wajcq8ha9e.some($_1t8d5wwtjcq8haao.fromDom(frame.dom().contentWindow.document));
  };
  var getWinFromFrame = function (frame) {
    return $_9m6n87wajcq8ha9e.from(frame.dom().contentWindow);
  };
  var getSelectionFromFrame = function (frame) {
    var optWin = getWinFromFrame(frame);
    return optWin.bind($_dkl1yh142jcq8hber.getExact);
  };
  var getFrame = function (editor) {
    return editor.getFrame();
  };
  var getOrDerive = function (name, f) {
    return function (editor) {
      var g = editor[name].getOrThunk(function () {
        var frame = getFrame(editor);
        return function () {
          return f(frame);
        };
      });
      return g();
    };
  };
  var getOrListen = function (editor, doc, name, type) {
    return editor[name].getOrThunk(function () {
      return function (handler) {
        return $_6s2oti13kjcq8hbca.bind(doc, type, handler);
      };
    });
  };
  var toRect$2 = function (rect) {
    return {
      left: $_dh3z58wbjcq8ha9h.constant(rect.left),
      top: $_dh3z58wbjcq8ha9h.constant(rect.top),
      right: $_dh3z58wbjcq8ha9h.constant(rect.right),
      bottom: $_dh3z58wbjcq8ha9h.constant(rect.bottom),
      width: $_dh3z58wbjcq8ha9h.constant(rect.width),
      height: $_dh3z58wbjcq8ha9h.constant(rect.height)
    };
  };
  var getActiveApi = function (editor) {
    var frame = getFrame(editor);
    var tryFallbackBox = function (win) {
      var isCollapsed = function (sel) {
        return $_darej4w8jcq8ha8v.eq(sel.start(), sel.finish()) && sel.soffset() === sel.foffset();
      };
      var toStartRect = function (sel) {
        var rect = sel.start().dom().getBoundingClientRect();
        return rect.width > 0 || rect.height > 0 ? $_9m6n87wajcq8ha9e.some(rect).map(toRect$2) : $_9m6n87wajcq8ha9e.none();
      };
      return $_dkl1yh142jcq8hber.getExact(win).filter(isCollapsed).bind(toStartRect);
    };
    return getBodyFromFrame(frame).bind(function (body) {
      return getDocFromFrame(frame).bind(function (doc) {
        return getWinFromFrame(frame).map(function (win) {
          var html = $_1t8d5wwtjcq8haao.fromDom(doc.dom().documentElement);
          var getCursorBox = editor.getCursorBox.getOrThunk(function () {
            return function () {
              return $_dkl1yh142jcq8hber.get(win).bind(function (sel) {
                return $_dkl1yh142jcq8hber.getFirstRect(win, sel).orThunk(function () {
                  return tryFallbackBox(win);
                });
              });
            };
          });
          var setSelection = editor.setSelection.getOrThunk(function () {
            return function (start, soffset, finish, foffset) {
              $_dkl1yh142jcq8hber.setExact(win, start, soffset, finish, foffset);
            };
          });
          var clearSelection = editor.clearSelection.getOrThunk(function () {
            return function () {
              $_dkl1yh142jcq8hber.clear(win);
            };
          });
          return {
            body: $_dh3z58wbjcq8ha9h.constant(body),
            doc: $_dh3z58wbjcq8ha9h.constant(doc),
            win: $_dh3z58wbjcq8ha9h.constant(win),
            html: $_dh3z58wbjcq8ha9h.constant(html),
            getSelection: $_dh3z58wbjcq8ha9h.curry(getSelectionFromFrame, frame),
            setSelection: setSelection,
            clearSelection: clearSelection,
            frame: $_dh3z58wbjcq8ha9h.constant(frame),
            onKeyup: getOrListen(editor, doc, 'onKeyup', 'keyup'),
            onNodeChanged: getOrListen(editor, doc, 'onNodeChanged', 'selectionchange'),
            onDomChanged: editor.onDomChanged,
            onScrollToCursor: editor.onScrollToCursor,
            onScrollToElement: editor.onScrollToElement,
            onToReading: editor.onToReading,
            onToEditing: editor.onToEditing,
            onToolbarScrollStart: editor.onToolbarScrollStart,
            onTouchContent: editor.onTouchContent,
            onTapContent: editor.onTapContent,
            onTouchToolstrip: editor.onTouchToolstrip,
            getCursorBox: getCursorBox
          };
        });
      });
    });
  };
  var $_96mhb614fjcq8hbg0 = {
    getBody: getOrDerive('getBody', getBodyFromFrame),
    getDoc: getOrDerive('getDoc', getDocFromFrame),
    getWin: getOrDerive('getWin', getWinFromFrame),
    getSelection: getOrDerive('getSelection', getSelectionFromFrame),
    getFrame: getFrame,
    getActiveApi: getActiveApi
  };

  var attr = 'data-ephox-mobile-fullscreen-style';
  var siblingStyles = 'display:none!important;';
  var ancestorPosition = 'position:absolute!important;';
  var ancestorStyles = 'top:0!important;left:0!important;margin:0' + '!important;padding:0!important;width:100%!important;';
  var bgFallback = 'background-color:rgb(255,255,255)!important;';
  var isAndroid = $_6a5cn8wgjcq8ha9o.detect().os.isAndroid();
  var matchColor = function (editorBody) {
    var color = $_bljwzsjcq8har2.get(editorBody, 'background-color');
    return color !== undefined && color !== '' ? 'background-color:' + color + '!important' : bgFallback;
  };
  var clobberStyles = function (container, editorBody) {
    var gatherSibilings = function (element) {
      var siblings = $_9rnqqqzkjcq8haqj.siblings(element, '*');
      return siblings;
    };
    var clobber = function (clobberStyle) {
      return function (element) {
        var styles = $_3kyqh4xwjcq8hajw.get(element, 'style');
        var backup = styles === undefined ? 'no-styles' : styles.trim();
        if (backup === clobberStyle) {
          return;
        } else {
          $_3kyqh4xwjcq8hajw.set(element, attr, backup);
          $_3kyqh4xwjcq8hajw.set(element, 'style', clobberStyle);
        }
      };
    };
    var ancestors = $_9rnqqqzkjcq8haqj.ancestors(container, '*');
    var siblings = $_dojsh2w9jcq8ha93.bind(ancestors, gatherSibilings);
    var bgColor = matchColor(editorBody);
    $_dojsh2w9jcq8ha93.each(siblings, clobber(siblingStyles));
    $_dojsh2w9jcq8ha93.each(ancestors, clobber(ancestorPosition + ancestorStyles + bgColor));
    var containerStyles = isAndroid === true ? '' : ancestorPosition;
    clobber(containerStyles + ancestorStyles + bgColor)(container);
  };
  var restoreStyles = function () {
    var clobberedEls = $_9rnqqqzkjcq8haqj.all('[' + attr + ']');
    $_dojsh2w9jcq8ha93.each(clobberedEls, function (element) {
      var restore = $_3kyqh4xwjcq8hajw.get(element, attr);
      if (restore !== 'no-styles') {
        $_3kyqh4xwjcq8hajw.set(element, 'style', restore);
      } else {
        $_3kyqh4xwjcq8hajw.remove(element, 'style');
      }
      $_3kyqh4xwjcq8hajw.remove(element, attr);
    });
  };
  var $_5bcj3p14gjcq8hbgf = {
    clobberStyles: clobberStyles,
    restoreStyles: restoreStyles
  };

  var tag = function () {
    var head = $_9rnmwhzmjcq8haqn.first('head').getOrDie();
    var nu = function () {
      var meta = $_1t8d5wwtjcq8haao.fromTag('meta');
      $_3kyqh4xwjcq8hajw.set(meta, 'name', 'viewport');
      $_1lvp6jy2jcq8hakj.append(head, meta);
      return meta;
    };
    var element = $_9rnmwhzmjcq8haqn.first('meta[name="viewport"]').getOrThunk(nu);
    var backup = $_3kyqh4xwjcq8hajw.get(element, 'content');
    var maximize = function () {
      $_3kyqh4xwjcq8hajw.set(element, 'content', 'width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1.0');
    };
    var restore = function () {
      if (backup !== undefined && backup !== null && backup.length > 0) {
        $_3kyqh4xwjcq8hajw.set(element, 'content', backup);
      } else {
        $_3kyqh4xwjcq8hajw.set(element, 'content', 'user-scalable=yes');
      }
    };
    return {
      maximize: maximize,
      restore: restore
    };
  };
  var $_vmwuw14hjcq8hbgl = { tag: tag };

  var create$4 = function (platform, mask) {
    var meta = $_vmwuw14hjcq8hbgl.tag();
    var androidApi = $_ffeym512ajcq8hb4a.api();
    var androidEvents = $_ffeym512ajcq8hb4a.api();
    var enter = function () {
      mask.hide();
      $_waygfxujcq8hajt.add(platform.container, $_30duqlz1jcq8haoh.resolve('fullscreen-maximized'));
      $_waygfxujcq8hajt.add(platform.container, $_30duqlz1jcq8haoh.resolve('android-maximized'));
      meta.maximize();
      $_waygfxujcq8hajt.add(platform.body, $_30duqlz1jcq8haoh.resolve('android-scroll-reload'));
      androidApi.set($_afsq9l13tjcq8hbdn.setup(platform.win, $_96mhb614fjcq8hbg0.getWin(platform.editor).getOrDie('no')));
      $_96mhb614fjcq8hbg0.getActiveApi(platform.editor).each(function (editorApi) {
        $_5bcj3p14gjcq8hbgf.clobberStyles(platform.container, editorApi.body());
        androidEvents.set($_9cvp4j13pjcq8hbd1.initEvents(editorApi, platform.toolstrip, platform.alloy));
      });
    };
    var exit = function () {
      meta.restore();
      mask.show();
      $_waygfxujcq8hajt.remove(platform.container, $_30duqlz1jcq8haoh.resolve('fullscreen-maximized'));
      $_waygfxujcq8hajt.remove(platform.container, $_30duqlz1jcq8haoh.resolve('android-maximized'));
      $_5bcj3p14gjcq8hbgf.restoreStyles();
      $_waygfxujcq8hajt.remove(platform.body, $_30duqlz1jcq8haoh.resolve('android-scroll-reload'));
      androidEvents.clear();
      androidApi.clear();
    };
    return {
      enter: enter,
      exit: exit
    };
  };
  var $_fd8x6a13ojcq8hbcq = { create: create$4 };

  var MobileSchema = $_g540acxhjcq8hadd.objOf([
    $_ah67nix2jcq8habi.strictObjOf('editor', [
      $_ah67nix2jcq8habi.strict('getFrame'),
      $_ah67nix2jcq8habi.option('getBody'),
      $_ah67nix2jcq8habi.option('getDoc'),
      $_ah67nix2jcq8habi.option('getWin'),
      $_ah67nix2jcq8habi.option('getSelection'),
      $_ah67nix2jcq8habi.option('setSelection'),
      $_ah67nix2jcq8habi.option('clearSelection'),
      $_ah67nix2jcq8habi.option('cursorSaver'),
      $_ah67nix2jcq8habi.option('onKeyup'),
      $_ah67nix2jcq8habi.option('onNodeChanged'),
      $_ah67nix2jcq8habi.option('getCursorBox'),
      $_ah67nix2jcq8habi.strict('onDomChanged'),
      $_ah67nix2jcq8habi.defaulted('onTouchContent', $_dh3z58wbjcq8ha9h.noop),
      $_ah67nix2jcq8habi.defaulted('onTapContent', $_dh3z58wbjcq8ha9h.noop),
      $_ah67nix2jcq8habi.defaulted('onTouchToolstrip', $_dh3z58wbjcq8ha9h.noop),
      $_ah67nix2jcq8habi.defaulted('onScrollToCursor', $_dh3z58wbjcq8ha9h.constant({ unbind: $_dh3z58wbjcq8ha9h.noop })),
      $_ah67nix2jcq8habi.defaulted('onScrollToElement', $_dh3z58wbjcq8ha9h.constant({ unbind: $_dh3z58wbjcq8ha9h.noop })),
      $_ah67nix2jcq8habi.defaulted('onToEditing', $_dh3z58wbjcq8ha9h.constant({ unbind: $_dh3z58wbjcq8ha9h.noop })),
      $_ah67nix2jcq8habi.defaulted('onToReading', $_dh3z58wbjcq8ha9h.constant({ unbind: $_dh3z58wbjcq8ha9h.noop })),
      $_ah67nix2jcq8habi.defaulted('onToolbarScrollStart', $_dh3z58wbjcq8ha9h.identity)
    ]),
    $_ah67nix2jcq8habi.strict('socket'),
    $_ah67nix2jcq8habi.strict('toolstrip'),
    $_ah67nix2jcq8habi.strict('dropup'),
    $_ah67nix2jcq8habi.strict('toolbar'),
    $_ah67nix2jcq8habi.strict('container'),
    $_ah67nix2jcq8habi.strict('alloy'),
    $_ah67nix2jcq8habi.state('win', function (spec) {
      return $_4h5j2xy3jcq8hakl.owner(spec.socket).dom().defaultView;
    }),
    $_ah67nix2jcq8habi.state('body', function (spec) {
      return $_1t8d5wwtjcq8haao.fromDom(spec.socket.dom().ownerDocument.body);
    }),
    $_ah67nix2jcq8habi.defaulted('translate', $_dh3z58wbjcq8ha9h.identity),
    $_ah67nix2jcq8habi.defaulted('setReadOnly', $_dh3z58wbjcq8ha9h.noop)
  ]);

  var adaptable = function (fn, rate) {
    var timer = null;
    var args = null;
    var cancel = function () {
      if (timer !== null) {
        clearTimeout(timer);
        timer = null;
        args = null;
      }
    };
    var throttle = function () {
      args = arguments;
      if (timer === null) {
        timer = setTimeout(function () {
          fn.apply(null, args);
          timer = null;
          args = null;
        }, rate);
      }
    };
    return {
      cancel: cancel,
      throttle: throttle
    };
  };
  var first$4 = function (fn, rate) {
    var timer = null;
    var cancel = function () {
      if (timer !== null) {
        clearTimeout(timer);
        timer = null;
      }
    };
    var throttle = function () {
      var args = arguments;
      if (timer === null) {
        timer = setTimeout(function () {
          fn.apply(null, args);
          timer = null;
          args = null;
        }, rate);
      }
    };
    return {
      cancel: cancel,
      throttle: throttle
    };
  };
  var last$3 = function (fn, rate) {
    var timer = null;
    var cancel = function () {
      if (timer !== null) {
        clearTimeout(timer);
        timer = null;
      }
    };
    var throttle = function () {
      var args = arguments;
      if (timer !== null)
        clearTimeout(timer);
      timer = setTimeout(function () {
        fn.apply(null, args);
        timer = null;
        args = null;
      }, rate);
    };
    return {
      cancel: cancel,
      throttle: throttle
    };
  };
  var $_mzt6114kjcq8hbh1 = {
    adaptable: adaptable,
    first: first$4,
    last: last$3
  };

  var sketch$10 = function (onView, translate) {
    var memIcon = $_4sw8ie11ejcq8hb07.record(Container.sketch({
      dom: $_21mxhc10qjcq8hawt.dom('<div aria-hidden="true" class="${prefix}-mask-tap-icon"></div>'),
      containerBehaviours: $_bfiithw4jcq8ha84.derive([Toggling.config({
          toggleClass: $_30duqlz1jcq8haoh.resolve('mask-tap-icon-selected'),
          toggleOnExecute: false
        })])
    }));
    var onViewThrottle = $_mzt6114kjcq8hbh1.first(onView, 200);
    return Container.sketch({
      dom: $_21mxhc10qjcq8hawt.dom('<div class="${prefix}-disabled-mask"></div>'),
      components: [Container.sketch({
          dom: $_21mxhc10qjcq8hawt.dom('<div class="${prefix}-content-container"></div>'),
          components: [Button.sketch({
              dom: $_21mxhc10qjcq8hawt.dom('<div class="${prefix}-content-tap-section"></div>'),
              components: [memIcon.asSpec()],
              action: function (button) {
                onViewThrottle.throttle();
              },
              buttonBehaviours: $_bfiithw4jcq8ha84.derive([Toggling.config({ toggleClass: $_30duqlz1jcq8haoh.resolve('mask-tap-icon-selected') })])
            })]
        })]
    });
  };
  var $_7qdmx214jjcq8hbgv = { sketch: sketch$10 };

  var produce = function (raw) {
    var mobile = $_g540acxhjcq8hadd.asRawOrDie('Getting AndroidWebapp schema', MobileSchema, raw);
    $_bljwzsjcq8har2.set(mobile.toolstrip, 'width', '100%');
    var onTap = function () {
      mobile.setReadOnly(true);
      mode.enter();
    };
    var mask = $_1e8bjm12kjcq8hb5s.build($_7qdmx214jjcq8hbgv.sketch(onTap, mobile.translate));
    mobile.alloy.add(mask);
    var maskApi = {
      show: function () {
        mobile.alloy.add(mask);
      },
      hide: function () {
        mobile.alloy.remove(mask);
      }
    };
    $_1lvp6jy2jcq8hakj.append(mobile.container, mask.element());
    var mode = $_fd8x6a13ojcq8hbcq.create(mobile, maskApi);
    return {
      setReadOnly: mobile.setReadOnly,
      refreshStructure: $_dh3z58wbjcq8ha9h.noop,
      enter: mode.enter,
      exit: mode.exit,
      destroy: $_dh3z58wbjcq8ha9h.noop
    };
  };
  var $_578sx613njcq8hbcl = { produce: produce };

  var schema$14 = [
    $_ah67nix2jcq8habi.defaulted('shell', true),
    $_b4pjyg10djcq8hau7.field('toolbarBehaviours', [Replacing])
  ];
  var enhanceGroups = function (detail) {
    return { behaviours: $_bfiithw4jcq8ha84.derive([Replacing.config({})]) };
  };
  var partTypes$1 = [$_50i5hr10kjcq8havc.optional({
      name: 'groups',
      overrides: enhanceGroups
    })];
  var $_bergtg14njcq8hbhj = {
    name: $_dh3z58wbjcq8ha9h.constant('Toolbar'),
    schema: $_dh3z58wbjcq8ha9h.constant(schema$14),
    parts: $_dh3z58wbjcq8ha9h.constant(partTypes$1)
  };

  var factory$4 = function (detail, components, spec, _externals) {
    var setGroups = function (toolbar, groups) {
      getGroupContainer(toolbar).fold(function () {
        console.error('Toolbar was defined to not be a shell, but no groups container was specified in components');
        throw new Error('Toolbar was defined to not be a shell, but no groups container was specified in components');
      }, function (container) {
        Replacing.set(container, groups);
      });
    };
    var getGroupContainer = function (component) {
      return detail.shell() ? $_9m6n87wajcq8ha9e.some(component) : $_70h8qs10ijcq8haut.getPart(component, detail, 'groups');
    };
    var extra = detail.shell() ? {
      behaviours: [Replacing.config({})],
      components: []
    } : {
      behaviours: [],
      components: components
    };
    return {
      uid: detail.uid(),
      dom: detail.dom(),
      components: extra.components,
      behaviours: $_936c00wyjcq8hab3.deepMerge($_bfiithw4jcq8ha84.derive(extra.behaviours), $_b4pjyg10djcq8hau7.get(detail.toolbarBehaviours())),
      apis: { setGroups: setGroups },
      domModification: { attributes: { role: 'group' } }
    };
  };
  var Toolbar = $_cocv7l10ejcq8hauc.composite({
    name: 'Toolbar',
    configFields: $_bergtg14njcq8hbhj.schema(),
    partFields: $_bergtg14njcq8hbhj.parts(),
    factory: factory$4,
    apis: {
      setGroups: function (apis, toolbar, groups) {
        apis.setGroups(toolbar, groups);
      }
    }
  });

  var schema$15 = [
    $_ah67nix2jcq8habi.strict('items'),
    $_fvpuwdytjcq8hanb.markers(['itemClass']),
    $_b4pjyg10djcq8hau7.field('tgroupBehaviours', [Keying])
  ];
  var partTypes$2 = [$_50i5hr10kjcq8havc.group({
      name: 'items',
      unit: 'item',
      overrides: function (detail) {
        return { domModification: { classes: [detail.markers().itemClass()] } };
      }
    })];
  var $_97pvu514pjcq8hbhq = {
    name: $_dh3z58wbjcq8ha9h.constant('ToolbarGroup'),
    schema: $_dh3z58wbjcq8ha9h.constant(schema$15),
    parts: $_dh3z58wbjcq8ha9h.constant(partTypes$2)
  };

  var factory$5 = function (detail, components, spec, _externals) {
    return $_936c00wyjcq8hab3.deepMerge({ dom: { attributes: { role: 'toolbar' } } }, {
      uid: detail.uid(),
      dom: detail.dom(),
      components: components,
      behaviours: $_936c00wyjcq8hab3.deepMerge($_bfiithw4jcq8ha84.derive([Keying.config({
          mode: 'flow',
          selector: '.' + detail.markers().itemClass()
        })]), $_b4pjyg10djcq8hau7.get(detail.tgroupBehaviours())),
      'debug.sketcher': spec['debug.sketcher']
    });
  };
  var ToolbarGroup = $_cocv7l10ejcq8hauc.composite({
    name: 'ToolbarGroup',
    configFields: $_97pvu514pjcq8hbhq.schema(),
    partFields: $_97pvu514pjcq8hbhq.parts(),
    factory: factory$5
  });

  var dataHorizontal = 'data-' + $_30duqlz1jcq8haoh.resolve('horizontal-scroll');
  var canScrollVertically = function (container) {
    container.dom().scrollTop = 1;
    var result = container.dom().scrollTop !== 0;
    container.dom().scrollTop = 0;
    return result;
  };
  var canScrollHorizontally = function (container) {
    container.dom().scrollLeft = 1;
    var result = container.dom().scrollLeft !== 0;
    container.dom().scrollLeft = 0;
    return result;
  };
  var hasVerticalScroll = function (container) {
    return container.dom().scrollTop > 0 || canScrollVertically(container);
  };
  var hasHorizontalScroll = function (container) {
    return container.dom().scrollLeft > 0 || canScrollHorizontally(container);
  };
  var markAsHorizontal = function (container) {
    $_3kyqh4xwjcq8hajw.set(container, dataHorizontal, 'true');
  };
  var hasScroll = function (container) {
    return $_3kyqh4xwjcq8hajw.get(container, dataHorizontal) === 'true' ? hasHorizontalScroll : hasVerticalScroll;
  };
  var exclusive = function (scope, selector) {
    return $_6s2oti13kjcq8hbca.bind(scope, 'touchmove', function (event) {
      $_9rnmwhzmjcq8haqn.closest(event.target(), selector).filter(hasScroll).fold(function () {
        event.raw().preventDefault();
      }, $_dh3z58wbjcq8ha9h.noop);
    });
  };
  var $_5mifz614qjcq8hbi0 = {
    exclusive: exclusive,
    markAsHorizontal: markAsHorizontal
  };

  var ScrollingToolbar = function () {
    var makeGroup = function (gSpec) {
      var scrollClass = gSpec.scrollable === true ? '${prefix}-toolbar-scrollable-group' : '';
      return {
        dom: $_21mxhc10qjcq8hawt.dom('<div aria-label="' + gSpec.label + '" class="${prefix}-toolbar-group ' + scrollClass + '"></div>'),
        tgroupBehaviours: $_bfiithw4jcq8ha84.derive([$_f3aums11sjcq8hb1v.config('adhoc-scrollable-toolbar', gSpec.scrollable === true ? [$_dkbc99w6jcq8ha8p.runOnInit(function (component, simulatedEvent) {
              $_bljwzsjcq8har2.set(component.element(), 'overflow-x', 'auto');
              $_5mifz614qjcq8hbi0.markAsHorizontal(component.element());
              $_8r8euk13hjcq8hbbx.register(component.element());
            })] : [])]),
        components: [Container.sketch({ components: [ToolbarGroup.parts().items({})] })],
        markers: { itemClass: $_30duqlz1jcq8haoh.resolve('toolbar-group-item') },
        items: gSpec.items
      };
    };
    var toolbar = $_1e8bjm12kjcq8hb5s.build(Toolbar.sketch({
      dom: $_21mxhc10qjcq8hawt.dom('<div class="${prefix}-toolbar"></div>'),
      components: [Toolbar.parts().groups({})],
      toolbarBehaviours: $_bfiithw4jcq8ha84.derive([
        Toggling.config({
          toggleClass: $_30duqlz1jcq8haoh.resolve('context-toolbar'),
          toggleOnExecute: false,
          aria: { mode: 'none' }
        }),
        Keying.config({ mode: 'cyclic' })
      ]),
      shell: true
    }));
    var wrapper = $_1e8bjm12kjcq8hb5s.build(Container.sketch({
      dom: { classes: [$_30duqlz1jcq8haoh.resolve('toolstrip')] },
      components: [$_1e8bjm12kjcq8hb5s.premade(toolbar)],
      containerBehaviours: $_bfiithw4jcq8ha84.derive([Toggling.config({
          toggleClass: $_30duqlz1jcq8haoh.resolve('android-selection-context-toolbar'),
          toggleOnExecute: false
        })])
    }));
    var resetGroups = function () {
      Toolbar.setGroups(toolbar, initGroups.get());
      Toggling.off(toolbar);
    };
    var initGroups = Cell([]);
    var setGroups = function (gs) {
      initGroups.set(gs);
      resetGroups();
    };
    var createGroups = function (gs) {
      return $_dojsh2w9jcq8ha93.map(gs, $_dh3z58wbjcq8ha9h.compose(ToolbarGroup.sketch, makeGroup));
    };
    var refresh = function () {
      Toolbar.refresh(toolbar);
    };
    var setContextToolbar = function (gs) {
      Toggling.on(toolbar);
      Toolbar.setGroups(toolbar, gs);
    };
    var restoreToolbar = function () {
      if (Toggling.isOn(toolbar)) {
        resetGroups();
      }
    };
    var focus = function () {
      Keying.focusIn(toolbar);
    };
    return {
      wrapper: $_dh3z58wbjcq8ha9h.constant(wrapper),
      toolbar: $_dh3z58wbjcq8ha9h.constant(toolbar),
      createGroups: createGroups,
      setGroups: setGroups,
      setContextToolbar: setContextToolbar,
      restoreToolbar: restoreToolbar,
      refresh: refresh,
      focus: focus
    };
  };

  var makeEditSwitch = function (webapp) {
    return $_1e8bjm12kjcq8hb5s.build(Button.sketch({
      dom: $_21mxhc10qjcq8hawt.dom('<div class="${prefix}-mask-edit-icon ${prefix}-icon"></div>'),
      action: function () {
        webapp.run(function (w) {
          w.setReadOnly(false);
        });
      }
    }));
  };
  var makeSocket = function () {
    return $_1e8bjm12kjcq8hb5s.build(Container.sketch({
      dom: $_21mxhc10qjcq8hawt.dom('<div class="${prefix}-editor-socket"></div>'),
      components: [],
      containerBehaviours: $_bfiithw4jcq8ha84.derive([Replacing.config({})])
    }));
  };
  var showEdit = function (socket, switchToEdit) {
    Replacing.append(socket, $_1e8bjm12kjcq8hb5s.premade(switchToEdit));
  };
  var hideEdit = function (socket, switchToEdit) {
    Replacing.remove(socket, switchToEdit);
  };
  var updateMode = function (socket, switchToEdit, readOnly, root) {
    var swap = readOnly === true ? Swapping.toAlpha : Swapping.toOmega;
    swap(root);
    var f = readOnly ? showEdit : hideEdit;
    f(socket, switchToEdit);
  };
  var $_gldja14rjcq8hbi6 = {
    makeEditSwitch: makeEditSwitch,
    makeSocket: makeSocket,
    updateMode: updateMode
  };

  var getAnimationRoot = function (component, slideConfig) {
    return slideConfig.getAnimationRoot().fold(function () {
      return component.element();
    }, function (get) {
      return get(component);
    });
  };
  var getDimensionProperty = function (slideConfig) {
    return slideConfig.dimension().property();
  };
  var getDimension = function (slideConfig, elem) {
    return slideConfig.dimension().getDimension()(elem);
  };
  var disableTransitions = function (component, slideConfig) {
    var root = getAnimationRoot(component, slideConfig);
    $_4wcngm12yjcq8hb8v.remove(root, [
      slideConfig.shrinkingClass(),
      slideConfig.growingClass()
    ]);
  };
  var setShrunk = function (component, slideConfig) {
    $_waygfxujcq8hajt.remove(component.element(), slideConfig.openClass());
    $_waygfxujcq8hajt.add(component.element(), slideConfig.closedClass());
    $_bljwzsjcq8har2.set(component.element(), getDimensionProperty(slideConfig), '0px');
    $_bljwzsjcq8har2.reflow(component.element());
  };
  var measureTargetSize = function (component, slideConfig) {
    setGrown(component, slideConfig);
    var expanded = getDimension(slideConfig, component.element());
    setShrunk(component, slideConfig);
    return expanded;
  };
  var setGrown = function (component, slideConfig) {
    $_waygfxujcq8hajt.remove(component.element(), slideConfig.closedClass());
    $_waygfxujcq8hajt.add(component.element(), slideConfig.openClass());
    $_bljwzsjcq8har2.remove(component.element(), getDimensionProperty(slideConfig));
  };
  var doImmediateShrink = function (component, slideConfig, slideState) {
    slideState.setCollapsed();
    $_bljwzsjcq8har2.set(component.element(), getDimensionProperty(slideConfig), getDimension(slideConfig, component.element()));
    $_bljwzsjcq8har2.reflow(component.element());
    disableTransitions(component, slideConfig);
    setShrunk(component, slideConfig);
    slideConfig.onStartShrink()(component);
    slideConfig.onShrunk()(component);
  };
  var doStartShrink = function (component, slideConfig, slideState) {
    slideState.setCollapsed();
    $_bljwzsjcq8har2.set(component.element(), getDimensionProperty(slideConfig), getDimension(slideConfig, component.element()));
    $_bljwzsjcq8har2.reflow(component.element());
    var root = getAnimationRoot(component, slideConfig);
    $_waygfxujcq8hajt.add(root, slideConfig.shrinkingClass());
    setShrunk(component, slideConfig);
    slideConfig.onStartShrink()(component);
  };
  var doStartGrow = function (component, slideConfig, slideState) {
    var fullSize = measureTargetSize(component, slideConfig);
    var root = getAnimationRoot(component, slideConfig);
    $_waygfxujcq8hajt.add(root, slideConfig.growingClass());
    setGrown(component, slideConfig);
    $_bljwzsjcq8har2.set(component.element(), getDimensionProperty(slideConfig), fullSize);
    slideState.setExpanded();
    slideConfig.onStartGrow()(component);
  };
  var grow = function (component, slideConfig, slideState) {
    if (!slideState.isExpanded())
      doStartGrow(component, slideConfig, slideState);
  };
  var shrink = function (component, slideConfig, slideState) {
    if (slideState.isExpanded())
      doStartShrink(component, slideConfig, slideState);
  };
  var immediateShrink = function (component, slideConfig, slideState) {
    if (slideState.isExpanded())
      doImmediateShrink(component, slideConfig, slideState);
  };
  var hasGrown = function (component, slideConfig, slideState) {
    return slideState.isExpanded();
  };
  var hasShrunk = function (component, slideConfig, slideState) {
    return slideState.isCollapsed();
  };
  var isGrowing = function (component, slideConfig, slideState) {
    var root = getAnimationRoot(component, slideConfig);
    return $_waygfxujcq8hajt.has(root, slideConfig.growingClass()) === true;
  };
  var isShrinking = function (component, slideConfig, slideState) {
    var root = getAnimationRoot(component, slideConfig);
    return $_waygfxujcq8hajt.has(root, slideConfig.shrinkingClass()) === true;
  };
  var isTransitioning = function (component, slideConfig, slideState) {
    return isGrowing(component, slideConfig, slideState) === true || isShrinking(component, slideConfig, slideState) === true;
  };
  var toggleGrow = function (component, slideConfig, slideState) {
    var f = slideState.isExpanded() ? doStartShrink : doStartGrow;
    f(component, slideConfig, slideState);
  };
  var $_9k3nk314vjcq8hbin = {
    grow: grow,
    shrink: shrink,
    immediateShrink: immediateShrink,
    hasGrown: hasGrown,
    hasShrunk: hasShrunk,
    isGrowing: isGrowing,
    isShrinking: isShrinking,
    isTransitioning: isTransitioning,
    toggleGrow: toggleGrow,
    disableTransitions: disableTransitions
  };

  var exhibit$5 = function (base, slideConfig) {
    var expanded = slideConfig.expanded();
    return expanded ? $_720ux0xkjcq8haj2.nu({
      classes: [slideConfig.openClass()],
      styles: {}
    }) : $_720ux0xkjcq8haj2.nu({
      classes: [slideConfig.closedClass()],
      styles: $_f2tmkex6jcq8hach.wrap(slideConfig.dimension().property(), '0px')
    });
  };
  var events$9 = function (slideConfig, slideState) {
    return $_dkbc99w6jcq8ha8p.derive([$_dkbc99w6jcq8ha8p.run($_gcr2umwxjcq8hab1.transitionend(), function (component, simulatedEvent) {
        var raw = simulatedEvent.event().raw();
        if (raw.propertyName === slideConfig.dimension().property()) {
          $_9k3nk314vjcq8hbin.disableTransitions(component, slideConfig, slideState);
          if (slideState.isExpanded())
            $_bljwzsjcq8har2.remove(component.element(), slideConfig.dimension().property());
          var notify = slideState.isExpanded() ? slideConfig.onGrown() : slideConfig.onShrunk();
          notify(component, simulatedEvent);
        }
      })]);
  };
  var $_30upov14ujcq8hbij = {
    exhibit: exhibit$5,
    events: events$9
  };

  var SlidingSchema = [
    $_ah67nix2jcq8habi.strict('closedClass'),
    $_ah67nix2jcq8habi.strict('openClass'),
    $_ah67nix2jcq8habi.strict('shrinkingClass'),
    $_ah67nix2jcq8habi.strict('growingClass'),
    $_ah67nix2jcq8habi.option('getAnimationRoot'),
    $_fvpuwdytjcq8hanb.onHandler('onShrunk'),
    $_fvpuwdytjcq8hanb.onHandler('onStartShrink'),
    $_fvpuwdytjcq8hanb.onHandler('onGrown'),
    $_fvpuwdytjcq8hanb.onHandler('onStartGrow'),
    $_ah67nix2jcq8habi.defaulted('expanded', false),
    $_ah67nix2jcq8habi.strictOf('dimension', $_g540acxhjcq8hadd.choose('property', {
      width: [
        $_fvpuwdytjcq8hanb.output('property', 'width'),
        $_fvpuwdytjcq8hanb.output('getDimension', function (elem) {
          return $_72au9u117jcq8hazb.get(elem) + 'px';
        })
      ],
      height: [
        $_fvpuwdytjcq8hanb.output('property', 'height'),
        $_fvpuwdytjcq8hanb.output('getDimension', function (elem) {
          return $_8ibl57zrjcq8har0.get(elem) + 'px';
        })
      ]
    }))
  ];

  var init$4 = function (spec) {
    var state = Cell(spec.expanded());
    var readState = function () {
      return 'expanded: ' + state.get();
    };
    return BehaviourState({
      isExpanded: function () {
        return state.get() === true;
      },
      isCollapsed: function () {
        return state.get() === false;
      },
      setCollapsed: $_dh3z58wbjcq8ha9h.curry(state.set, false),
      setExpanded: $_dh3z58wbjcq8ha9h.curry(state.set, true),
      readState: readState
    });
  };
  var $_c9my7f14xjcq8hbiz = { init: init$4 };

  var Sliding = $_bfiithw4jcq8ha84.create({
    fields: SlidingSchema,
    name: 'sliding',
    active: $_30upov14ujcq8hbij,
    apis: $_9k3nk314vjcq8hbin,
    state: $_c9my7f14xjcq8hbiz
  });

  var build$2 = function (refresh, scrollIntoView) {
    var dropup = $_1e8bjm12kjcq8hb5s.build(Container.sketch({
      dom: {
        tag: 'div',
        classes: $_30duqlz1jcq8haoh.resolve('dropup')
      },
      components: [],
      containerBehaviours: $_bfiithw4jcq8ha84.derive([
        Replacing.config({}),
        Sliding.config({
          closedClass: $_30duqlz1jcq8haoh.resolve('dropup-closed'),
          openClass: $_30duqlz1jcq8haoh.resolve('dropup-open'),
          shrinkingClass: $_30duqlz1jcq8haoh.resolve('dropup-shrinking'),
          growingClass: $_30duqlz1jcq8haoh.resolve('dropup-growing'),
          dimension: { property: 'height' },
          onShrunk: function (component) {
            refresh();
            scrollIntoView();
            Replacing.set(component, []);
          },
          onGrown: function (component) {
            refresh();
            scrollIntoView();
          }
        }),
        $_dnir0tz0jcq8hao8.orientation(function (component, data) {
          disappear($_dh3z58wbjcq8ha9h.noop);
        })
      ])
    }));
    var appear = function (menu, update, component) {
      if (Sliding.hasShrunk(dropup) === true && Sliding.isTransitioning(dropup) === false) {
        window.requestAnimationFrame(function () {
          update(component);
          Replacing.set(dropup, [menu()]);
          Sliding.grow(dropup);
        });
      }
    };
    var disappear = function (onReadyToShrink) {
      window.requestAnimationFrame(function () {
        onReadyToShrink();
        Sliding.shrink(dropup);
      });
    };
    return {
      appear: appear,
      disappear: disappear,
      component: $_dh3z58wbjcq8ha9h.constant(dropup),
      element: dropup.element
    };
  };
  var $_b1805w14sjcq8hbic = { build: build$2 };

  var isDangerous = function (event) {
    return event.raw().which === $_fg3xg6zejcq8hapq.BACKSPACE()[0] && !$_dojsh2w9jcq8ha93.contains([
      'input',
      'textarea'
    ], $_4z03v7xxjcq8hak1.name(event.target()));
  };
  var isFirefox = $_6a5cn8wgjcq8ha9o.detect().browser.isFirefox();
  var settingsSchema = $_g540acxhjcq8hadd.objOfOnly([
    $_ah67nix2jcq8habi.strictFunction('triggerEvent'),
    $_ah67nix2jcq8habi.strictFunction('broadcastEvent'),
    $_ah67nix2jcq8habi.defaulted('stopBackspace', true)
  ]);
  var bindFocus = function (container, handler) {
    if (isFirefox) {
      return $_6s2oti13kjcq8hbca.capture(container, 'focus', handler);
    } else {
      return $_6s2oti13kjcq8hbca.bind(container, 'focusin', handler);
    }
  };
  var bindBlur = function (container, handler) {
    if (isFirefox) {
      return $_6s2oti13kjcq8hbca.capture(container, 'blur', handler);
    } else {
      return $_6s2oti13kjcq8hbca.bind(container, 'focusout', handler);
    }
  };
  var setup$2 = function (container, rawSettings) {
    var settings = $_g540acxhjcq8hadd.asRawOrDie('Getting GUI events settings', settingsSchema, rawSettings);
    var pointerEvents = $_6a5cn8wgjcq8ha9o.detect().deviceType.isTouch() ? [
      'touchstart',
      'touchmove',
      'touchend',
      'gesturestart'
    ] : [
      'mousedown',
      'mouseup',
      'mouseover',
      'mousemove',
      'mouseout',
      'click'
    ];
    var tapEvent = $_29zxna13rjcq8hbde.monitor(settings);
    var simpleEvents = $_dojsh2w9jcq8ha93.map(pointerEvents.concat([
      'selectstart',
      'input',
      'contextmenu',
      'change',
      'transitionend',
      'dragstart',
      'dragover',
      'drop'
    ]), function (type) {
      return $_6s2oti13kjcq8hbca.bind(container, type, function (event) {
        tapEvent.fireIfReady(event, type).each(function (tapStopped) {
          if (tapStopped)
            event.kill();
        });
        var stopped = settings.triggerEvent(type, event);
        if (stopped)
          event.kill();
      });
    });
    var onKeydown = $_6s2oti13kjcq8hbca.bind(container, 'keydown', function (event) {
      var stopped = settings.triggerEvent('keydown', event);
      if (stopped)
        event.kill();
      else if (settings.stopBackspace === true && isDangerous(event)) {
        event.prevent();
      }
    });
    var onFocusIn = bindFocus(container, function (event) {
      var stopped = settings.triggerEvent('focusin', event);
      if (stopped)
        event.kill();
    });
    var onFocusOut = bindBlur(container, function (event) {
      var stopped = settings.triggerEvent('focusout', event);
      if (stopped)
        event.kill();
      setTimeout(function () {
        settings.triggerEvent($_51ilu1wwjcq8haax.postBlur(), event);
      }, 0);
    });
    var defaultView = $_4h5j2xy3jcq8hakl.defaultView(container);
    var onWindowScroll = $_6s2oti13kjcq8hbca.bind(defaultView, 'scroll', function (event) {
      var stopped = settings.broadcastEvent($_51ilu1wwjcq8haax.windowScroll(), event);
      if (stopped)
        event.kill();
    });
    var unbind = function () {
      $_dojsh2w9jcq8ha93.each(simpleEvents, function (e) {
        e.unbind();
      });
      onKeydown.unbind();
      onFocusIn.unbind();
      onFocusOut.unbind();
      onWindowScroll.unbind();
    };
    return { unbind: unbind };
  };
  var $_g6xxp150jcq8hbjr = { setup: setup$2 };

  var derive$3 = function (rawEvent, rawTarget) {
    var source = $_f2tmkex6jcq8hach.readOptFrom(rawEvent, 'target').map(function (getTarget) {
      return getTarget();
    }).getOr(rawTarget);
    return Cell(source);
  };
  var $_4di5nq152jcq8hbk8 = { derive: derive$3 };

  var fromSource = function (event, source) {
    var stopper = Cell(false);
    var cutter = Cell(false);
    var stop = function () {
      stopper.set(true);
    };
    var cut = function () {
      cutter.set(true);
    };
    return {
      stop: stop,
      cut: cut,
      isStopped: stopper.get,
      isCut: cutter.get,
      event: $_dh3z58wbjcq8ha9h.constant(event),
      setSource: source.set,
      getSource: source.get
    };
  };
  var fromExternal = function (event) {
    var stopper = Cell(false);
    var stop = function () {
      stopper.set(true);
    };
    return {
      stop: stop,
      cut: $_dh3z58wbjcq8ha9h.noop,
      isStopped: stopper.get,
      isCut: $_dh3z58wbjcq8ha9h.constant(false),
      event: $_dh3z58wbjcq8ha9h.constant(event),
      setTarget: $_dh3z58wbjcq8ha9h.die(new Error('Cannot set target of a broadcasted event')),
      getTarget: $_dh3z58wbjcq8ha9h.die(new Error('Cannot get target of a broadcasted event'))
    };
  };
  var fromTarget = function (event, target) {
    var source = Cell(target);
    return fromSource(event, source);
  };
  var $_4k7685153jcq8hbkb = {
    fromSource: fromSource,
    fromExternal: fromExternal,
    fromTarget: fromTarget
  };

  var adt$6 = $_dho4a6x4jcq8habz.generate([
    { stopped: [] },
    { resume: ['element'] },
    { complete: [] }
  ]);
  var doTriggerHandler = function (lookup, eventType, rawEvent, target, source, logger) {
    var handler = lookup(eventType, target);
    var simulatedEvent = $_4k7685153jcq8hbkb.fromSource(rawEvent, source);
    return handler.fold(function () {
      logger.logEventNoHandlers(eventType, target);
      return adt$6.complete();
    }, function (handlerInfo) {
      var descHandler = handlerInfo.descHandler();
      var eventHandler = $_fcktxg12vjcq8hb88.getHandler(descHandler);
      eventHandler(simulatedEvent);
      if (simulatedEvent.isStopped()) {
        logger.logEventStopped(eventType, handlerInfo.element(), descHandler.purpose());
        return adt$6.stopped();
      } else if (simulatedEvent.isCut()) {
        logger.logEventCut(eventType, handlerInfo.element(), descHandler.purpose());
        return adt$6.complete();
      } else
        return $_4h5j2xy3jcq8hakl.parent(handlerInfo.element()).fold(function () {
          logger.logNoParent(eventType, handlerInfo.element(), descHandler.purpose());
          return adt$6.complete();
        }, function (parent) {
          logger.logEventResponse(eventType, handlerInfo.element(), descHandler.purpose());
          return adt$6.resume(parent);
        });
    });
  };
  var doTriggerOnUntilStopped = function (lookup, eventType, rawEvent, rawTarget, source, logger) {
    return doTriggerHandler(lookup, eventType, rawEvent, rawTarget, source, logger).fold(function () {
      return true;
    }, function (parent) {
      return doTriggerOnUntilStopped(lookup, eventType, rawEvent, parent, source, logger);
    }, function () {
      return false;
    });
  };
  var triggerHandler = function (lookup, eventType, rawEvent, target, logger) {
    var source = $_4di5nq152jcq8hbk8.derive(rawEvent, target);
    return doTriggerHandler(lookup, eventType, rawEvent, target, source, logger);
  };
  var broadcast = function (listeners, rawEvent, logger) {
    var simulatedEvent = $_4k7685153jcq8hbkb.fromExternal(rawEvent);
    $_dojsh2w9jcq8ha93.each(listeners, function (listener) {
      var descHandler = listener.descHandler();
      var handler = $_fcktxg12vjcq8hb88.getHandler(descHandler);
      handler(simulatedEvent);
    });
    return simulatedEvent.isStopped();
  };
  var triggerUntilStopped = function (lookup, eventType, rawEvent, logger) {
    var rawTarget = rawEvent.target();
    return triggerOnUntilStopped(lookup, eventType, rawEvent, rawTarget, logger);
  };
  var triggerOnUntilStopped = function (lookup, eventType, rawEvent, rawTarget, logger) {
    var source = $_4di5nq152jcq8hbk8.derive(rawEvent, rawTarget);
    return doTriggerOnUntilStopped(lookup, eventType, rawEvent, rawTarget, source, logger);
  };
  var $_4y348u151jcq8hbk2 = {
    triggerHandler: triggerHandler,
    triggerUntilStopped: triggerUntilStopped,
    triggerOnUntilStopped: triggerOnUntilStopped,
    broadcast: broadcast
  };

  var closest$4 = function (target, transform, isRoot) {
    var delegate = $_1vm5o1yijcq8ham7.closest(target, function (elem) {
      return transform(elem).isSome();
    }, isRoot);
    return delegate.bind(transform);
  };
  var $_6tfu1z156jcq8hbkp = { closest: closest$4 };

  var eventHandler = $_4e5yxhxmjcq8hajd.immutable('element', 'descHandler');
  var messageHandler = function (id, handler) {
    return {
      id: $_dh3z58wbjcq8ha9h.constant(id),
      descHandler: $_dh3z58wbjcq8ha9h.constant(handler)
    };
  };
  var EventRegistry = function () {
    var registry = {};
    var registerId = function (extraArgs, id, events) {
      $_et458cx0jcq8hab6.each(events, function (v, k) {
        var handlers = registry[k] !== undefined ? registry[k] : {};
        handlers[id] = $_fcktxg12vjcq8hb88.curryArgs(v, extraArgs);
        registry[k] = handlers;
      });
    };
    var findHandler = function (handlers, elem) {
      return $_3r222m10mjcq8haw3.read(elem).fold(function (err) {
        return $_9m6n87wajcq8ha9e.none();
      }, function (id) {
        var reader = $_f2tmkex6jcq8hach.readOpt(id);
        return handlers.bind(reader).map(function (descHandler) {
          return eventHandler(elem, descHandler);
        });
      });
    };
    var filterByType = function (type) {
      return $_f2tmkex6jcq8hach.readOptFrom(registry, type).map(function (handlers) {
        return $_et458cx0jcq8hab6.mapToArray(handlers, function (f, id) {
          return messageHandler(id, f);
        });
      }).getOr([]);
    };
    var find = function (isAboveRoot, type, target) {
      var readType = $_f2tmkex6jcq8hach.readOpt(type);
      var handlers = readType(registry);
      return $_6tfu1z156jcq8hbkp.closest(target, function (elem) {
        return findHandler(handlers, elem);
      }, isAboveRoot);
    };
    var unregisterId = function (id) {
      $_et458cx0jcq8hab6.each(registry, function (handlersById, eventName) {
        if (handlersById.hasOwnProperty(id))
          delete handlersById[id];
      });
    };
    return {
      registerId: registerId,
      unregisterId: unregisterId,
      filterByType: filterByType,
      find: find
    };
  };

  var Registry = function () {
    var events = EventRegistry();
    var components = {};
    var readOrTag = function (component) {
      var elem = component.element();
      return $_3r222m10mjcq8haw3.read(elem).fold(function () {
        return $_3r222m10mjcq8haw3.write('uid-', component.element());
      }, function (uid) {
        return uid;
      });
    };
    var failOnDuplicate = function (component, tagId) {
      var conflict = components[tagId];
      if (conflict === component)
        unregister(component);
      else
        throw new Error('The tagId "' + tagId + '" is already used by: ' + $_2g4xv2y9jcq8hali.element(conflict.element()) + '\nCannot use it for: ' + $_2g4xv2y9jcq8hali.element(component.element()) + '\n' + 'The conflicting element is' + ($_4axtmsy7jcq8hal6.inBody(conflict.element()) ? ' ' : ' not ') + 'already in the DOM');
    };
    var register = function (component) {
      var tagId = readOrTag(component);
      if ($_f2tmkex6jcq8hach.hasKey(components, tagId))
        failOnDuplicate(component, tagId);
      var extraArgs = [component];
      events.registerId(extraArgs, tagId, component.events());
      components[tagId] = component;
    };
    var unregister = function (component) {
      $_3r222m10mjcq8haw3.read(component.element()).each(function (tagId) {
        components[tagId] = undefined;
        events.unregisterId(tagId);
      });
    };
    var filter = function (type) {
      return events.filterByType(type);
    };
    var find = function (isAboveRoot, type, target) {
      return events.find(isAboveRoot, type, target);
    };
    var getById = function (id) {
      return $_f2tmkex6jcq8hach.readOpt(id)(components);
    };
    return {
      find: find,
      filter: filter,
      register: register,
      unregister: unregister,
      getById: getById
    };
  };

  var create$6 = function () {
    var root = $_1e8bjm12kjcq8hb5s.build(Container.sketch({ dom: { tag: 'div' } }));
    return takeover(root);
  };
  var takeover = function (root) {
    var isAboveRoot = function (el) {
      return $_4h5j2xy3jcq8hakl.parent(root.element()).fold(function () {
        return true;
      }, function (parent) {
        return $_darej4w8jcq8ha8v.eq(el, parent);
      });
    };
    var registry = Registry();
    var lookup = function (eventName, target) {
      return registry.find(isAboveRoot, eventName, target);
    };
    var domEvents = $_g6xxp150jcq8hbjr.setup(root.element(), {
      triggerEvent: function (eventName, event) {
        return $_dxnqasy8jcq8hal9.monitorEvent(eventName, event.target(), function (logger) {
          return $_4y348u151jcq8hbk2.triggerUntilStopped(lookup, eventName, event, logger);
        });
      },
      broadcastEvent: function (eventName, event) {
        var listeners = registry.filter(eventName);
        return $_4y348u151jcq8hbk2.broadcast(listeners, event);
      }
    });
    var systemApi = SystemApi({
      debugInfo: $_dh3z58wbjcq8ha9h.constant('real'),
      triggerEvent: function (customType, target, data) {
        $_dxnqasy8jcq8hal9.monitorEvent(customType, target, function (logger) {
          $_4y348u151jcq8hbk2.triggerOnUntilStopped(lookup, customType, data, target, logger);
        });
      },
      triggerFocus: function (target, originator) {
        $_3r222m10mjcq8haw3.read(target).fold(function () {
          $_dgsby1ygjcq8ham1.focus(target);
        }, function (_alloyId) {
          $_dxnqasy8jcq8hal9.monitorEvent($_51ilu1wwjcq8haax.focus(), target, function (logger) {
            $_4y348u151jcq8hbk2.triggerHandler(lookup, $_51ilu1wwjcq8haax.focus(), {
              originator: $_dh3z58wbjcq8ha9h.constant(originator),
              target: $_dh3z58wbjcq8ha9h.constant(target)
            }, target, logger);
          });
        });
      },
      triggerEscape: function (comp, simulatedEvent) {
        systemApi.triggerEvent('keydown', comp.element(), simulatedEvent.event());
      },
      getByUid: function (uid) {
        return getByUid(uid);
      },
      getByDom: function (elem) {
        return getByDom(elem);
      },
      build: $_1e8bjm12kjcq8hb5s.build,
      addToGui: function (c) {
        add(c);
      },
      removeFromGui: function (c) {
        remove(c);
      },
      addToWorld: function (c) {
        addToWorld(c);
      },
      removeFromWorld: function (c) {
        removeFromWorld(c);
      },
      broadcast: function (message) {
        broadcast(message);
      },
      broadcastOn: function (channels, message) {
        broadcastOn(channels, message);
      }
    });
    var addToWorld = function (component) {
      component.connect(systemApi);
      if (!$_4z03v7xxjcq8hak1.isText(component.element())) {
        registry.register(component);
        $_dojsh2w9jcq8ha93.each(component.components(), addToWorld);
        systemApi.triggerEvent($_51ilu1wwjcq8haax.systemInit(), component.element(), { target: $_dh3z58wbjcq8ha9h.constant(component.element()) });
      }
    };
    var removeFromWorld = function (component) {
      if (!$_4z03v7xxjcq8hak1.isText(component.element())) {
        $_dojsh2w9jcq8ha93.each(component.components(), removeFromWorld);
        registry.unregister(component);
      }
      component.disconnect();
    };
    var add = function (component) {
      $_8oadbiy1jcq8haka.attach(root, component);
    };
    var remove = function (component) {
      $_8oadbiy1jcq8haka.detach(component);
    };
    var destroy = function () {
      domEvents.unbind();
      $_axfxsny5jcq8hal1.remove(root.element());
    };
    var broadcastData = function (data) {
      var receivers = registry.filter($_51ilu1wwjcq8haax.receive());
      $_dojsh2w9jcq8ha93.each(receivers, function (receiver) {
        var descHandler = receiver.descHandler();
        var handler = $_fcktxg12vjcq8hb88.getHandler(descHandler);
        handler(data);
      });
    };
    var broadcast = function (message) {
      broadcastData({
        universal: $_dh3z58wbjcq8ha9h.constant(true),
        data: $_dh3z58wbjcq8ha9h.constant(message)
      });
    };
    var broadcastOn = function (channels, message) {
      broadcastData({
        universal: $_dh3z58wbjcq8ha9h.constant(false),
        channels: $_dh3z58wbjcq8ha9h.constant(channels),
        data: $_dh3z58wbjcq8ha9h.constant(message)
      });
    };
    var getByUid = function (uid) {
      return registry.getById(uid).fold(function () {
        return $_yvshix8jcq8hacp.error(new Error('Could not find component with uid: "' + uid + '" in system.'));
      }, $_yvshix8jcq8hacp.value);
    };
    var getByDom = function (elem) {
      return $_3r222m10mjcq8haw3.read(elem).bind(getByUid);
    };
    addToWorld(root);
    return {
      root: $_dh3z58wbjcq8ha9h.constant(root),
      element: root.element,
      destroy: destroy,
      add: add,
      remove: remove,
      getByUid: getByUid,
      getByDom: getByDom,
      addToWorld: addToWorld,
      removeFromWorld: removeFromWorld,
      broadcast: broadcast,
      broadcastOn: broadcastOn
    };
  };
  var $_5z4j3y14zjcq8hbj9 = {
    create: create$6,
    takeover: takeover
  };

  var READ_ONLY_MODE_CLASS = $_dh3z58wbjcq8ha9h.constant($_30duqlz1jcq8haoh.resolve('readonly-mode'));
  var EDIT_MODE_CLASS = $_dh3z58wbjcq8ha9h.constant($_30duqlz1jcq8haoh.resolve('edit-mode'));
  var OuterContainer = function (spec) {
    var root = $_1e8bjm12kjcq8hb5s.build(Container.sketch({
      dom: { classes: [$_30duqlz1jcq8haoh.resolve('outer-container')].concat(spec.classes) },
      containerBehaviours: $_bfiithw4jcq8ha84.derive([Swapping.config({
          alpha: READ_ONLY_MODE_CLASS(),
          omega: EDIT_MODE_CLASS()
        })])
    }));
    return $_5z4j3y14zjcq8hbj9.takeover(root);
  };

  var AndroidRealm = function (scrollIntoView) {
    var alloy = OuterContainer({ classes: [$_30duqlz1jcq8haoh.resolve('android-container')] });
    var toolbar = ScrollingToolbar();
    var webapp = $_ffeym512ajcq8hb4a.api();
    var switchToEdit = $_gldja14rjcq8hbi6.makeEditSwitch(webapp);
    var socket = $_gldja14rjcq8hbi6.makeSocket();
    var dropup = $_b1805w14sjcq8hbic.build($_dh3z58wbjcq8ha9h.noop, scrollIntoView);
    alloy.add(toolbar.wrapper());
    alloy.add(socket);
    alloy.add(dropup.component());
    var setToolbarGroups = function (rawGroups) {
      var groups = toolbar.createGroups(rawGroups);
      toolbar.setGroups(groups);
    };
    var setContextToolbar = function (rawGroups) {
      var groups = toolbar.createGroups(rawGroups);
      toolbar.setContextToolbar(groups);
    };
    var focusToolbar = function () {
      toolbar.focus();
    };
    var restoreToolbar = function () {
      toolbar.restoreToolbar();
    };
    var init = function (spec) {
      webapp.set($_578sx613njcq8hbcl.produce(spec));
    };
    var exit = function () {
      webapp.run(function (w) {
        w.exit();
        Replacing.remove(socket, switchToEdit);
      });
    };
    var updateMode = function (readOnly) {
      $_gldja14rjcq8hbi6.updateMode(socket, switchToEdit, readOnly, alloy.root());
    };
    return {
      system: $_dh3z58wbjcq8ha9h.constant(alloy),
      element: alloy.element,
      init: init,
      exit: exit,
      setToolbarGroups: setToolbarGroups,
      setContextToolbar: setContextToolbar,
      focusToolbar: focusToolbar,
      restoreToolbar: restoreToolbar,
      updateMode: updateMode,
      socket: $_dh3z58wbjcq8ha9h.constant(socket),
      dropup: $_dh3z58wbjcq8ha9h.constant(dropup)
    };
  };

  var initEvents$1 = function (editorApi, iosApi, toolstrip, socket, dropup) {
    var saveSelectionFirst = function () {
      iosApi.run(function (api) {
        api.highlightSelection();
      });
    };
    var refreshIosSelection = function () {
      iosApi.run(function (api) {
        api.refreshSelection();
      });
    };
    var scrollToY = function (yTop, height) {
      var y = yTop - socket.dom().scrollTop;
      iosApi.run(function (api) {
        api.scrollIntoView(y, y + height);
      });
    };
    var scrollToElement = function (target) {
      scrollToY(iosApi, socket);
    };
    var scrollToCursor = function () {
      editorApi.getCursorBox().each(function (box) {
        scrollToY(box.top(), box.height());
      });
    };
    var clearSelection = function () {
      iosApi.run(function (api) {
        api.clearSelection();
      });
    };
    var clearAndRefresh = function () {
      clearSelection();
      refreshThrottle.throttle();
    };
    var refreshView = function () {
      scrollToCursor();
      iosApi.run(function (api) {
        api.syncHeight();
      });
    };
    var reposition = function () {
      var toolbarHeight = $_8ibl57zrjcq8har0.get(toolstrip);
      iosApi.run(function (api) {
        api.setViewportOffset(toolbarHeight);
      });
      refreshIosSelection();
      refreshView();
    };
    var toEditing = function () {
      iosApi.run(function (api) {
        api.toEditing();
      });
    };
    var toReading = function () {
      iosApi.run(function (api) {
        api.toReading();
      });
    };
    var onToolbarTouch = function (event) {
      iosApi.run(function (api) {
        api.onToolbarTouch(event);
      });
    };
    var tapping = $_6osijo13qjcq8hbdc.monitor(editorApi);
    var refreshThrottle = $_mzt6114kjcq8hbh1.last(refreshView, 300);
    var listeners = [
      editorApi.onKeyup(clearAndRefresh),
      editorApi.onNodeChanged(refreshIosSelection),
      editorApi.onDomChanged(refreshThrottle.throttle),
      editorApi.onDomChanged(refreshIosSelection),
      editorApi.onScrollToCursor(function (tinyEvent) {
        tinyEvent.preventDefault();
        refreshThrottle.throttle();
      }),
      editorApi.onScrollToElement(function (event) {
        scrollToElement(event.element());
      }),
      editorApi.onToEditing(toEditing),
      editorApi.onToReading(toReading),
      $_6s2oti13kjcq8hbca.bind(editorApi.doc(), 'touchend', function (touchEvent) {
        if ($_darej4w8jcq8ha8v.eq(editorApi.html(), touchEvent.target()) || $_darej4w8jcq8ha8v.eq(editorApi.body(), touchEvent.target())) {
        }
      }),
      $_6s2oti13kjcq8hbca.bind(toolstrip, 'transitionend', function (transitionEvent) {
        if (transitionEvent.raw().propertyName === 'height') {
          reposition();
        }
      }),
      $_6s2oti13kjcq8hbca.capture(toolstrip, 'touchstart', function (touchEvent) {
        saveSelectionFirst();
        onToolbarTouch(touchEvent);
        editorApi.onTouchToolstrip();
      }),
      $_6s2oti13kjcq8hbca.bind(editorApi.body(), 'touchstart', function (evt) {
        clearSelection();
        editorApi.onTouchContent();
        tapping.fireTouchstart(evt);
      }),
      tapping.onTouchmove(),
      tapping.onTouchend(),
      $_6s2oti13kjcq8hbca.bind(editorApi.body(), 'click', function (event) {
        event.kill();
      }),
      $_6s2oti13kjcq8hbca.bind(toolstrip, 'touchmove', function () {
        editorApi.onToolbarScrollStart();
      })
    ];
    var destroy = function () {
      $_dojsh2w9jcq8ha93.each(listeners, function (l) {
        l.unbind();
      });
    };
    return { destroy: destroy };
  };
  var $_an4x2z15ajcq8hbli = { initEvents: initEvents$1 };

  var refreshInput = function (input) {
    var start = input.dom().selectionStart;
    var end = input.dom().selectionEnd;
    var dir = input.dom().selectionDirection;
    setTimeout(function () {
      input.dom().setSelectionRange(start, end, dir);
      $_dgsby1ygjcq8ham1.focus(input);
    }, 50);
  };
  var refresh = function (winScope) {
    var sel = winScope.getSelection();
    if (sel.rangeCount > 0) {
      var br = sel.getRangeAt(0);
      var r = winScope.document.createRange();
      r.setStart(br.startContainer, br.startOffset);
      r.setEnd(br.endContainer, br.endOffset);
      sel.removeAllRanges();
      sel.addRange(r);
    }
  };
  var $_8jsngb15ejcq8hbme = {
    refreshInput: refreshInput,
    refresh: refresh
  };

  var resume$1 = function (cWin, frame) {
    $_dgsby1ygjcq8ham1.active().each(function (active) {
      if (!$_darej4w8jcq8ha8v.eq(active, frame)) {
        $_dgsby1ygjcq8ham1.blur(active);
      }
    });
    cWin.focus();
    $_dgsby1ygjcq8ham1.focus($_1t8d5wwtjcq8haao.fromDom(cWin.document.body));
    $_8jsngb15ejcq8hbme.refresh(cWin);
  };
  var $_16dj5015djcq8hbma = { resume: resume$1 };

  var FakeSelection = function (win, frame) {
    var doc = win.document;
    var container = $_1t8d5wwtjcq8haao.fromTag('div');
    $_waygfxujcq8hajt.add(container, $_30duqlz1jcq8haoh.resolve('unfocused-selections'));
    $_1lvp6jy2jcq8hakj.append($_1t8d5wwtjcq8haao.fromDom(doc.documentElement), container);
    var onTouch = $_6s2oti13kjcq8hbca.bind(container, 'touchstart', function (event) {
      event.prevent();
      $_16dj5015djcq8hbma.resume(win, frame);
      clear();
    });
    var make = function (rectangle) {
      var span = $_1t8d5wwtjcq8haao.fromTag('span');
      $_4wcngm12yjcq8hb8v.add(span, [
        $_30duqlz1jcq8haoh.resolve('layer-editor'),
        $_30duqlz1jcq8haoh.resolve('unfocused-selection')
      ]);
      $_bljwzsjcq8har2.setAll(span, {
        left: rectangle.left() + 'px',
        top: rectangle.top() + 'px',
        width: rectangle.width() + 'px',
        height: rectangle.height() + 'px'
      });
      return span;
    };
    var update = function () {
      clear();
      var rectangles = $_8y90mv13wjcq8hbe1.getRectangles(win);
      var spans = $_dojsh2w9jcq8ha93.map(rectangles, make);
      $_hk3r9y6jcq8hal3.append(container, spans);
    };
    var clear = function () {
      $_axfxsny5jcq8hal1.empty(container);
    };
    var destroy = function () {
      onTouch.unbind();
      $_axfxsny5jcq8hal1.remove(container);
    };
    var isActive = function () {
      return $_4h5j2xy3jcq8hakl.children(container).length > 0;
    };
    return {
      update: update,
      isActive: isActive,
      destroy: destroy,
      clear: clear
    };
  };

  var nu$9 = function (baseFn) {
    var data = $_9m6n87wajcq8ha9e.none();
    var callbacks = [];
    var map = function (f) {
      return nu$9(function (nCallback) {
        get(function (data) {
          nCallback(f(data));
        });
      });
    };
    var get = function (nCallback) {
      if (isReady())
        call(nCallback);
      else
        callbacks.push(nCallback);
    };
    var set = function (x) {
      data = $_9m6n87wajcq8ha9e.some(x);
      run(callbacks);
      callbacks = [];
    };
    var isReady = function () {
      return data.isSome();
    };
    var run = function (cbs) {
      $_dojsh2w9jcq8ha93.each(cbs, call);
    };
    var call = function (cb) {
      data.each(function (x) {
        setTimeout(function () {
          cb(x);
        }, 0);
      });
    };
    baseFn(set);
    return {
      get: get,
      map: map,
      isReady: isReady
    };
  };
  var pure$2 = function (a) {
    return nu$9(function (callback) {
      callback(a);
    });
  };
  var $_g9jlcr15hjcq8hbmp = {
    nu: nu$9,
    pure: pure$2
  };

  var bounce = function (f) {
    return function () {
      var args = Array.prototype.slice.call(arguments);
      var me = this;
      setTimeout(function () {
        f.apply(me, args);
      }, 0);
    };
  };
  var $_39w78f15ijcq8hbmq = { bounce: bounce };

  var nu$8 = function (baseFn) {
    var get = function (callback) {
      baseFn($_39w78f15ijcq8hbmq.bounce(callback));
    };
    var map = function (fab) {
      return nu$8(function (callback) {
        get(function (a) {
          var value = fab(a);
          callback(value);
        });
      });
    };
    var bind = function (aFutureB) {
      return nu$8(function (callback) {
        get(function (a) {
          aFutureB(a).get(callback);
        });
      });
    };
    var anonBind = function (futureB) {
      return nu$8(function (callback) {
        get(function (a) {
          futureB.get(callback);
        });
      });
    };
    var toLazy = function () {
      return $_g9jlcr15hjcq8hbmp.nu(get);
    };
    return {
      map: map,
      bind: bind,
      anonBind: anonBind,
      toLazy: toLazy,
      get: get
    };
  };
  var pure$1 = function (a) {
    return nu$8(function (callback) {
      callback(a);
    });
  };
  var $_e2vt0f15gjcq8hbmn = {
    nu: nu$8,
    pure: pure$1
  };

  var adjust = function (value, destination, amount) {
    if (Math.abs(value - destination) <= amount) {
      return $_9m6n87wajcq8ha9e.none();
    } else if (value < destination) {
      return $_9m6n87wajcq8ha9e.some(value + amount);
    } else {
      return $_9m6n87wajcq8ha9e.some(value - amount);
    }
  };
  var create$8 = function () {
    var interval = null;
    var animate = function (getCurrent, destination, amount, increment, doFinish, rate) {
      var finished = false;
      var finish = function (v) {
        finished = true;
        doFinish(v);
      };
      clearInterval(interval);
      var abort = function (v) {
        clearInterval(interval);
        finish(v);
      };
      interval = setInterval(function () {
        var value = getCurrent();
        adjust(value, destination, amount).fold(function () {
          clearInterval(interval);
          finish(destination);
        }, function (s) {
          increment(s, abort);
          if (!finished) {
            var newValue = getCurrent();
            if (newValue !== s || Math.abs(newValue - destination) > Math.abs(value - destination)) {
              clearInterval(interval);
              finish(destination);
            }
          }
        });
      }, rate);
    };
    return { animate: animate };
  };
  var $_4ltq9q15jjcq8hbms = {
    create: create$8,
    adjust: adjust
  };

  var findDevice = function (deviceWidth, deviceHeight) {
    var devices = [
      {
        width: 320,
        height: 480,
        keyboard: {
          portrait: 300,
          landscape: 240
        }
      },
      {
        width: 320,
        height: 568,
        keyboard: {
          portrait: 300,
          landscape: 240
        }
      },
      {
        width: 375,
        height: 667,
        keyboard: {
          portrait: 305,
          landscape: 240
        }
      },
      {
        width: 414,
        height: 736,
        keyboard: {
          portrait: 320,
          landscape: 240
        }
      },
      {
        width: 768,
        height: 1024,
        keyboard: {
          portrait: 320,
          landscape: 400
        }
      },
      {
        width: 1024,
        height: 1366,
        keyboard: {
          portrait: 380,
          landscape: 460
        }
      }
    ];
    return $_4d7j4zyejcq8halz.findMap(devices, function (device) {
      return deviceWidth <= device.width && deviceHeight <= device.height ? $_9m6n87wajcq8ha9e.some(device.keyboard) : $_9m6n87wajcq8ha9e.none();
    }).getOr({
      portrait: deviceHeight / 5,
      landscape: deviceWidth / 4
    });
  };
  var $_e94jcc15mjcq8hbnf = { findDevice: findDevice };

  var softKeyboardLimits = function (outerWindow) {
    return $_e94jcc15mjcq8hbnf.findDevice(outerWindow.screen.width, outerWindow.screen.height);
  };
  var accountableKeyboardHeight = function (outerWindow) {
    var portrait = $_fxqkqq13jjcq8hbc4.get(outerWindow).isPortrait();
    var limits = softKeyboardLimits(outerWindow);
    var keyboard = portrait ? limits.portrait : limits.landscape;
    var visualScreenHeight = portrait ? outerWindow.screen.height : outerWindow.screen.width;
    return visualScreenHeight - outerWindow.innerHeight > keyboard ? 0 : keyboard;
  };
  var getGreenzone = function (socket, dropup) {
    var outerWindow = $_4h5j2xy3jcq8hakl.owner(socket).dom().defaultView;
    var viewportHeight = $_8ibl57zrjcq8har0.get(socket) + $_8ibl57zrjcq8har0.get(dropup);
    var acc = accountableKeyboardHeight(outerWindow);
    return viewportHeight - acc;
  };
  var updatePadding = function (contentBody, socket, dropup) {
    var greenzoneHeight = getGreenzone(socket, dropup);
    var deltaHeight = $_8ibl57zrjcq8har0.get(socket) + $_8ibl57zrjcq8har0.get(dropup) - greenzoneHeight;
    $_bljwzsjcq8har2.set(contentBody, 'padding-bottom', deltaHeight + 'px');
  };
  var $_exszqq15ljcq8hbnb = {
    getGreenzone: getGreenzone,
    updatePadding: updatePadding
  };

  var fixture = $_dho4a6x4jcq8habz.generate([
    {
      fixed: [
        'element',
        'property',
        'offsetY'
      ]
    },
    {
      scroller: [
        'element',
        'offsetY'
      ]
    }
  ]);
  var yFixedData = 'data-' + $_30duqlz1jcq8haoh.resolve('position-y-fixed');
  var yFixedProperty = 'data-' + $_30duqlz1jcq8haoh.resolve('y-property');
  var yScrollingData = 'data-' + $_30duqlz1jcq8haoh.resolve('scrolling');
  var windowSizeData = 'data-' + $_30duqlz1jcq8haoh.resolve('last-window-height');
  var getYFixedData = function (element) {
    return $_91010l13vjcq8hbdz.safeParse(element, yFixedData);
  };
  var getYFixedProperty = function (element) {
    return $_3kyqh4xwjcq8hajw.get(element, yFixedProperty);
  };
  var getLastWindowSize = function (element) {
    return $_91010l13vjcq8hbdz.safeParse(element, windowSizeData);
  };
  var classifyFixed = function (element, offsetY) {
    var prop = getYFixedProperty(element);
    return fixture.fixed(element, prop, offsetY);
  };
  var classifyScrolling = function (element, offsetY) {
    return fixture.scroller(element, offsetY);
  };
  var classify = function (element) {
    var offsetY = getYFixedData(element);
    var classifier = $_3kyqh4xwjcq8hajw.get(element, yScrollingData) === 'true' ? classifyScrolling : classifyFixed;
    return classifier(element, offsetY);
  };
  var findFixtures = function (container) {
    var candidates = $_9rnqqqzkjcq8haqj.descendants(container, '[' + yFixedData + ']');
    return $_dojsh2w9jcq8ha93.map(candidates, classify);
  };
  var takeoverToolbar = function (toolbar) {
    var oldToolbarStyle = $_3kyqh4xwjcq8hajw.get(toolbar, 'style');
    $_bljwzsjcq8har2.setAll(toolbar, {
      position: 'absolute',
      top: '0px'
    });
    $_3kyqh4xwjcq8hajw.set(toolbar, yFixedData, '0px');
    $_3kyqh4xwjcq8hajw.set(toolbar, yFixedProperty, 'top');
    var restore = function () {
      $_3kyqh4xwjcq8hajw.set(toolbar, 'style', oldToolbarStyle || '');
      $_3kyqh4xwjcq8hajw.remove(toolbar, yFixedData);
      $_3kyqh4xwjcq8hajw.remove(toolbar, yFixedProperty);
    };
    return { restore: restore };
  };
  var takeoverViewport = function (toolbarHeight, height, viewport) {
    var oldViewportStyle = $_3kyqh4xwjcq8hajw.get(viewport, 'style');
    $_8r8euk13hjcq8hbbx.register(viewport);
    $_bljwzsjcq8har2.setAll(viewport, {
      position: 'absolute',
      height: height + 'px',
      width: '100%',
      top: toolbarHeight + 'px'
    });
    $_3kyqh4xwjcq8hajw.set(viewport, yFixedData, toolbarHeight + 'px');
    $_3kyqh4xwjcq8hajw.set(viewport, yScrollingData, 'true');
    $_3kyqh4xwjcq8hajw.set(viewport, yFixedProperty, 'top');
    var restore = function () {
      $_8r8euk13hjcq8hbbx.deregister(viewport);
      $_3kyqh4xwjcq8hajw.set(viewport, 'style', oldViewportStyle || '');
      $_3kyqh4xwjcq8hajw.remove(viewport, yFixedData);
      $_3kyqh4xwjcq8hajw.remove(viewport, yScrollingData);
      $_3kyqh4xwjcq8hajw.remove(viewport, yFixedProperty);
    };
    return { restore: restore };
  };
  var takeoverDropup = function (dropup, toolbarHeight, viewportHeight) {
    var oldDropupStyle = $_3kyqh4xwjcq8hajw.get(dropup, 'style');
    $_bljwzsjcq8har2.setAll(dropup, {
      position: 'absolute',
      bottom: '0px'
    });
    $_3kyqh4xwjcq8hajw.set(dropup, yFixedData, '0px');
    $_3kyqh4xwjcq8hajw.set(dropup, yFixedProperty, 'bottom');
    var restore = function () {
      $_3kyqh4xwjcq8hajw.set(dropup, 'style', oldDropupStyle || '');
      $_3kyqh4xwjcq8hajw.remove(dropup, yFixedData);
      $_3kyqh4xwjcq8hajw.remove(dropup, yFixedProperty);
    };
    return { restore: restore };
  };
  var deriveViewportHeight = function (viewport, toolbarHeight, dropupHeight) {
    var outerWindow = $_4h5j2xy3jcq8hakl.owner(viewport).dom().defaultView;
    var winH = outerWindow.innerHeight;
    $_3kyqh4xwjcq8hajw.set(viewport, windowSizeData, winH + 'px');
    return winH - toolbarHeight - dropupHeight;
  };
  var takeover$1 = function (viewport, contentBody, toolbar, dropup) {
    var outerWindow = $_4h5j2xy3jcq8hakl.owner(viewport).dom().defaultView;
    var toolbarSetup = takeoverToolbar(toolbar);
    var toolbarHeight = $_8ibl57zrjcq8har0.get(toolbar);
    var dropupHeight = $_8ibl57zrjcq8har0.get(dropup);
    var viewportHeight = deriveViewportHeight(viewport, toolbarHeight, dropupHeight);
    var viewportSetup = takeoverViewport(toolbarHeight, viewportHeight, viewport);
    var dropupSetup = takeoverDropup(dropup, toolbarHeight, viewportHeight);
    var isActive = true;
    var restore = function () {
      isActive = false;
      toolbarSetup.restore();
      viewportSetup.restore();
      dropupSetup.restore();
    };
    var isExpanding = function () {
      var currentWinHeight = outerWindow.innerHeight;
      var lastWinHeight = getLastWindowSize(viewport);
      return currentWinHeight > lastWinHeight;
    };
    var refresh = function () {
      if (isActive) {
        var newToolbarHeight = $_8ibl57zrjcq8har0.get(toolbar);
        var dropupHeight_1 = $_8ibl57zrjcq8har0.get(dropup);
        var newHeight = deriveViewportHeight(viewport, newToolbarHeight, dropupHeight_1);
        $_3kyqh4xwjcq8hajw.set(viewport, yFixedData, newToolbarHeight + 'px');
        $_bljwzsjcq8har2.set(viewport, 'height', newHeight + 'px');
        $_bljwzsjcq8har2.set(dropup, 'bottom', -(newToolbarHeight + newHeight + dropupHeight_1) + 'px');
        $_exszqq15ljcq8hbnb.updatePadding(contentBody, viewport, dropup);
      }
    };
    var setViewportOffset = function (newYOffset) {
      var offsetPx = newYOffset + 'px';
      $_3kyqh4xwjcq8hajw.set(viewport, yFixedData, offsetPx);
      refresh();
    };
    $_exszqq15ljcq8hbnb.updatePadding(contentBody, viewport, dropup);
    return {
      setViewportOffset: setViewportOffset,
      isExpanding: isExpanding,
      isShrinking: $_dh3z58wbjcq8ha9h.not(isExpanding),
      refresh: refresh,
      restore: restore
    };
  };
  var $_8oou7j15kjcq8hbn1 = {
    findFixtures: findFixtures,
    takeover: takeover$1,
    getYFixedData: getYFixedData
  };

  var animator = $_4ltq9q15jjcq8hbms.create();
  var ANIMATION_STEP = 15;
  var NUM_TOP_ANIMATION_FRAMES = 10;
  var ANIMATION_RATE = 10;
  var lastScroll = 'data-' + $_30duqlz1jcq8haoh.resolve('last-scroll-top');
  var getTop = function (element) {
    var raw = $_bljwzsjcq8har2.getRaw(element, 'top').getOr(0);
    return parseInt(raw, 10);
  };
  var getScrollTop = function (element) {
    return parseInt(element.dom().scrollTop, 10);
  };
  var moveScrollAndTop = function (element, destination, finalTop) {
    return $_e2vt0f15gjcq8hbmn.nu(function (callback) {
      var getCurrent = $_dh3z58wbjcq8ha9h.curry(getScrollTop, element);
      var update = function (newScroll) {
        element.dom().scrollTop = newScroll;
        $_bljwzsjcq8har2.set(element, 'top', getTop(element) + ANIMATION_STEP + 'px');
      };
      var finish = function () {
        element.dom().scrollTop = destination;
        $_bljwzsjcq8har2.set(element, 'top', finalTop + 'px');
        callback(destination);
      };
      animator.animate(getCurrent, destination, ANIMATION_STEP, update, finish, ANIMATION_RATE);
    });
  };
  var moveOnlyScroll = function (element, destination) {
    return $_e2vt0f15gjcq8hbmn.nu(function (callback) {
      var getCurrent = $_dh3z58wbjcq8ha9h.curry(getScrollTop, element);
      $_3kyqh4xwjcq8hajw.set(element, lastScroll, getCurrent());
      var update = function (newScroll, abort) {
        var previous = $_91010l13vjcq8hbdz.safeParse(element, lastScroll);
        if (previous !== element.dom().scrollTop) {
          abort(element.dom().scrollTop);
        } else {
          element.dom().scrollTop = newScroll;
          $_3kyqh4xwjcq8hajw.set(element, lastScroll, newScroll);
        }
      };
      var finish = function () {
        element.dom().scrollTop = destination;
        $_3kyqh4xwjcq8hajw.set(element, lastScroll, destination);
        callback(destination);
      };
      var distance = Math.abs(destination - getCurrent());
      var step = Math.ceil(distance / NUM_TOP_ANIMATION_FRAMES);
      animator.animate(getCurrent, destination, step, update, finish, ANIMATION_RATE);
    });
  };
  var moveOnlyTop = function (element, destination) {
    return $_e2vt0f15gjcq8hbmn.nu(function (callback) {
      var getCurrent = $_dh3z58wbjcq8ha9h.curry(getTop, element);
      var update = function (newTop) {
        $_bljwzsjcq8har2.set(element, 'top', newTop + 'px');
      };
      var finish = function () {
        update(destination);
        callback(destination);
      };
      var distance = Math.abs(destination - getCurrent());
      var step = Math.ceil(distance / NUM_TOP_ANIMATION_FRAMES);
      animator.animate(getCurrent, destination, step, update, finish, ANIMATION_RATE);
    });
  };
  var updateTop = function (element, amount) {
    var newTop = amount + $_8oou7j15kjcq8hbn1.getYFixedData(element) + 'px';
    $_bljwzsjcq8har2.set(element, 'top', newTop);
  };
  var moveWindowScroll = function (toolbar, viewport, destY) {
    var outerWindow = $_4h5j2xy3jcq8hakl.owner(toolbar).dom().defaultView;
    return $_e2vt0f15gjcq8hbmn.nu(function (callback) {
      updateTop(toolbar, destY);
      updateTop(viewport, destY);
      outerWindow.scrollTo(0, destY);
      callback(destY);
    });
  };
  var $_y2tzt15fjcq8hbmg = {
    moveScrollAndTop: moveScrollAndTop,
    moveOnlyScroll: moveOnlyScroll,
    moveOnlyTop: moveOnlyTop,
    moveWindowScroll: moveWindowScroll
  };

  var BackgroundActivity = function (doAction) {
    var action = Cell($_g9jlcr15hjcq8hbmp.pure({}));
    var start = function (value) {
      var future = $_g9jlcr15hjcq8hbmp.nu(function (callback) {
        return doAction(value).get(callback);
      });
      action.set(future);
    };
    var idle = function (g) {
      action.get().get(function () {
        g();
      });
    };
    return {
      start: start,
      idle: idle
    };
  };

  var scrollIntoView = function (cWin, socket, dropup, top, bottom) {
    var greenzone = $_exszqq15ljcq8hbnb.getGreenzone(socket, dropup);
    var refreshCursor = $_dh3z58wbjcq8ha9h.curry($_8jsngb15ejcq8hbme.refresh, cWin);
    if (top > greenzone || bottom > greenzone) {
      $_y2tzt15fjcq8hbmg.moveOnlyScroll(socket, socket.dom().scrollTop - greenzone + bottom).get(refreshCursor);
    } else if (top < 0) {
      $_y2tzt15fjcq8hbmg.moveOnlyScroll(socket, socket.dom().scrollTop + top).get(refreshCursor);
    } else {
    }
  };
  var $_n3pe615ojcq8hbnm = { scrollIntoView: scrollIntoView };

  var par$1 = function (asyncValues, nu) {
    return nu(function (callback) {
      var r = [];
      var count = 0;
      var cb = function (i) {
        return function (value) {
          r[i] = value;
          count++;
          if (count >= asyncValues.length) {
            callback(r);
          }
        };
      };
      if (asyncValues.length === 0) {
        callback([]);
      } else {
        $_dojsh2w9jcq8ha93.each(asyncValues, function (asyncValue, i) {
          asyncValue.get(cb(i));
        });
      }
    });
  };
  var $_7ut5il15rjcq8hbnu = { par: par$1 };

  var par = function (futures) {
    return $_7ut5il15rjcq8hbnu.par(futures, $_e2vt0f15gjcq8hbmn.nu);
  };
  var mapM = function (array, fn) {
    var futures = $_dojsh2w9jcq8ha93.map(array, fn);
    return par(futures);
  };
  var compose$1 = function (f, g) {
    return function (a) {
      return g(a).bind(f);
    };
  };
  var $_7ilzn715qjcq8hbnt = {
    par: par,
    mapM: mapM,
    compose: compose$1
  };

  var updateFixed = function (element, property, winY, offsetY) {
    var destination = winY + offsetY;
    $_bljwzsjcq8har2.set(element, property, destination + 'px');
    return $_e2vt0f15gjcq8hbmn.pure(offsetY);
  };
  var updateScrollingFixed = function (element, winY, offsetY) {
    var destTop = winY + offsetY;
    var oldProp = $_bljwzsjcq8har2.getRaw(element, 'top').getOr(offsetY);
    var delta = destTop - parseInt(oldProp, 10);
    var destScroll = element.dom().scrollTop + delta;
    return $_y2tzt15fjcq8hbmg.moveScrollAndTop(element, destScroll, destTop);
  };
  var updateFixture = function (fixture, winY) {
    return fixture.fold(function (element, property, offsetY) {
      return updateFixed(element, property, winY, offsetY);
    }, function (element, offsetY) {
      return updateScrollingFixed(element, winY, offsetY);
    });
  };
  var updatePositions = function (container, winY) {
    var fixtures = $_8oou7j15kjcq8hbn1.findFixtures(container);
    var updates = $_dojsh2w9jcq8ha93.map(fixtures, function (fixture) {
      return updateFixture(fixture, winY);
    });
    return $_7ilzn715qjcq8hbnt.par(updates);
  };
  var $_65nsum15pjcq8hbno = { updatePositions: updatePositions };

  var input = function (parent, operation) {
    var input = $_1t8d5wwtjcq8haao.fromTag('input');
    $_bljwzsjcq8har2.setAll(input, {
      opacity: '0',
      position: 'absolute',
      top: '-1000px',
      left: '-1000px'
    });
    $_1lvp6jy2jcq8hakj.append(parent, input);
    $_dgsby1ygjcq8ham1.focus(input);
    operation(input);
    $_axfxsny5jcq8hal1.remove(input);
  };
  var $_959koa15sjcq8hbny = { input: input };

  var VIEW_MARGIN = 5;
  var register$2 = function (toolstrip, socket, container, outerWindow, structure, cWin) {
    var scroller = BackgroundActivity(function (y) {
      return $_y2tzt15fjcq8hbmg.moveWindowScroll(toolstrip, socket, y);
    });
    var scrollBounds = function () {
      var rects = $_8y90mv13wjcq8hbe1.getRectangles(cWin);
      return $_9m6n87wajcq8ha9e.from(rects[0]).bind(function (rect) {
        var viewTop = rect.top() - socket.dom().scrollTop;
        var outside = viewTop > outerWindow.innerHeight + VIEW_MARGIN || viewTop < -VIEW_MARGIN;
        return outside ? $_9m6n87wajcq8ha9e.some({
          top: $_dh3z58wbjcq8ha9h.constant(viewTop),
          bottom: $_dh3z58wbjcq8ha9h.constant(viewTop + rect.height())
        }) : $_9m6n87wajcq8ha9e.none();
      });
    };
    var scrollThrottle = $_mzt6114kjcq8hbh1.last(function () {
      scroller.idle(function () {
        $_65nsum15pjcq8hbno.updatePositions(container, outerWindow.pageYOffset).get(function () {
          var extraScroll = scrollBounds();
          extraScroll.each(function (extra) {
            socket.dom().scrollTop = socket.dom().scrollTop + extra.top();
          });
          scroller.start(0);
          structure.refresh();
        });
      });
    }, 1000);
    var onScroll = $_6s2oti13kjcq8hbca.bind($_1t8d5wwtjcq8haao.fromDom(outerWindow), 'scroll', function () {
      if (outerWindow.pageYOffset < 0) {
        return;
      }
      scrollThrottle.throttle();
    });
    $_65nsum15pjcq8hbno.updatePositions(container, outerWindow.pageYOffset).get($_dh3z58wbjcq8ha9h.identity);
    return { unbind: onScroll.unbind };
  };
  var setup$3 = function (bag) {
    var cWin = bag.cWin();
    var ceBody = bag.ceBody();
    var socket = bag.socket();
    var toolstrip = bag.toolstrip();
    var toolbar = bag.toolbar();
    var contentElement = bag.contentElement();
    var keyboardType = bag.keyboardType();
    var outerWindow = bag.outerWindow();
    var dropup = bag.dropup();
    var structure = $_8oou7j15kjcq8hbn1.takeover(socket, ceBody, toolstrip, dropup);
    var keyboardModel = keyboardType(bag.outerBody(), cWin, $_4axtmsy7jcq8hal6.body(), contentElement, toolstrip, toolbar);
    var toEditing = function () {
      keyboardModel.toEditing();
      clearSelection();
    };
    var toReading = function () {
      keyboardModel.toReading();
    };
    var onToolbarTouch = function (event) {
      keyboardModel.onToolbarTouch(event);
    };
    var onOrientation = $_fxqkqq13jjcq8hbc4.onChange(outerWindow, {
      onChange: $_dh3z58wbjcq8ha9h.noop,
      onReady: structure.refresh
    });
    onOrientation.onAdjustment(function () {
      structure.refresh();
    });
    var onResize = $_6s2oti13kjcq8hbca.bind($_1t8d5wwtjcq8haao.fromDom(outerWindow), 'resize', function () {
      if (structure.isExpanding()) {
        structure.refresh();
      }
    });
    var onScroll = register$2(toolstrip, socket, bag.outerBody(), outerWindow, structure, cWin);
    var unfocusedSelection = FakeSelection(cWin, contentElement);
    var refreshSelection = function () {
      if (unfocusedSelection.isActive()) {
        unfocusedSelection.update();
      }
    };
    var highlightSelection = function () {
      unfocusedSelection.update();
    };
    var clearSelection = function () {
      unfocusedSelection.clear();
    };
    var scrollIntoView = function (top, bottom) {
      $_n3pe615ojcq8hbnm.scrollIntoView(cWin, socket, dropup, top, bottom);
    };
    var syncHeight = function () {
      $_bljwzsjcq8har2.set(contentElement, 'height', contentElement.dom().contentWindow.document.body.scrollHeight + 'px');
    };
    var setViewportOffset = function (newYOffset) {
      structure.setViewportOffset(newYOffset);
      $_y2tzt15fjcq8hbmg.moveOnlyTop(socket, newYOffset).get($_dh3z58wbjcq8ha9h.identity);
    };
    var destroy = function () {
      structure.restore();
      onOrientation.destroy();
      onScroll.unbind();
      onResize.unbind();
      keyboardModel.destroy();
      unfocusedSelection.destroy();
      $_959koa15sjcq8hbny.input($_4axtmsy7jcq8hal6.body(), $_dgsby1ygjcq8ham1.blur);
    };
    return {
      toEditing: toEditing,
      toReading: toReading,
      onToolbarTouch: onToolbarTouch,
      refreshSelection: refreshSelection,
      clearSelection: clearSelection,
      highlightSelection: highlightSelection,
      scrollIntoView: scrollIntoView,
      updateToolbarPadding: $_dh3z58wbjcq8ha9h.noop,
      setViewportOffset: setViewportOffset,
      syncHeight: syncHeight,
      refreshStructure: structure.refresh,
      destroy: destroy
    };
  };
  var $_7oygr915bjcq8hblq = { setup: setup$3 };

  var stubborn = function (outerBody, cWin, page, frame) {
    var toEditing = function () {
      $_16dj5015djcq8hbma.resume(cWin, frame);
    };
    var toReading = function () {
      $_959koa15sjcq8hbny.input(outerBody, $_dgsby1ygjcq8ham1.blur);
    };
    var captureInput = $_6s2oti13kjcq8hbca.bind(page, 'keydown', function (evt) {
      if (!$_dojsh2w9jcq8ha93.contains([
          'input',
          'textarea'
        ], $_4z03v7xxjcq8hak1.name(evt.target()))) {
        toEditing();
      }
    });
    var onToolbarTouch = function () {
    };
    var destroy = function () {
      captureInput.unbind();
    };
    return {
      toReading: toReading,
      toEditing: toEditing,
      onToolbarTouch: onToolbarTouch,
      destroy: destroy
    };
  };
  var timid = function (outerBody, cWin, page, frame) {
    var dismissKeyboard = function () {
      $_dgsby1ygjcq8ham1.blur(frame);
    };
    var onToolbarTouch = function () {
      dismissKeyboard();
    };
    var toReading = function () {
      dismissKeyboard();
    };
    var toEditing = function () {
      $_16dj5015djcq8hbma.resume(cWin, frame);
    };
    return {
      toReading: toReading,
      toEditing: toEditing,
      onToolbarTouch: onToolbarTouch,
      destroy: $_dh3z58wbjcq8ha9h.noop
    };
  };
  var $_50cb5d15tjcq8hbo5 = {
    stubborn: stubborn,
    timid: timid
  };

  var create$7 = function (platform, mask) {
    var meta = $_vmwuw14hjcq8hbgl.tag();
    var priorState = $_ffeym512ajcq8hb4a.value();
    var scrollEvents = $_ffeym512ajcq8hb4a.value();
    var iosApi = $_ffeym512ajcq8hb4a.api();
    var iosEvents = $_ffeym512ajcq8hb4a.api();
    var enter = function () {
      mask.hide();
      var doc = $_1t8d5wwtjcq8haao.fromDom(document);
      $_96mhb614fjcq8hbg0.getActiveApi(platform.editor).each(function (editorApi) {
        priorState.set({
          socketHeight: $_bljwzsjcq8har2.getRaw(platform.socket, 'height'),
          iframeHeight: $_bljwzsjcq8har2.getRaw(editorApi.frame(), 'height'),
          outerScroll: document.body.scrollTop
        });
        scrollEvents.set({ exclusives: $_5mifz614qjcq8hbi0.exclusive(doc, '.' + $_8r8euk13hjcq8hbbx.scrollable()) });
        $_waygfxujcq8hajt.add(platform.container, $_30duqlz1jcq8haoh.resolve('fullscreen-maximized'));
        $_5bcj3p14gjcq8hbgf.clobberStyles(platform.container, editorApi.body());
        meta.maximize();
        $_bljwzsjcq8har2.set(platform.socket, 'overflow', 'scroll');
        $_bljwzsjcq8har2.set(platform.socket, '-webkit-overflow-scrolling', 'touch');
        $_dgsby1ygjcq8ham1.focus(editorApi.body());
        var setupBag = $_4e5yxhxmjcq8hajd.immutableBag([
          'cWin',
          'ceBody',
          'socket',
          'toolstrip',
          'toolbar',
          'dropup',
          'contentElement',
          'cursor',
          'keyboardType',
          'isScrolling',
          'outerWindow',
          'outerBody'
        ], []);
        iosApi.set($_7oygr915bjcq8hblq.setup(setupBag({
          cWin: editorApi.win(),
          ceBody: editorApi.body(),
          socket: platform.socket,
          toolstrip: platform.toolstrip,
          toolbar: platform.toolbar,
          dropup: platform.dropup.element(),
          contentElement: editorApi.frame(),
          cursor: $_dh3z58wbjcq8ha9h.noop,
          outerBody: platform.body,
          outerWindow: platform.win,
          keyboardType: $_50cb5d15tjcq8hbo5.stubborn,
          isScrolling: function () {
            return scrollEvents.get().exists(function (s) {
              return s.socket.isScrolling();
            });
          }
        })));
        iosApi.run(function (api) {
          api.syncHeight();
        });
        iosEvents.set($_an4x2z15ajcq8hbli.initEvents(editorApi, iosApi, platform.toolstrip, platform.socket, platform.dropup));
      });
    };
    var exit = function () {
      meta.restore();
      iosEvents.clear();
      iosApi.clear();
      mask.show();
      priorState.on(function (s) {
        s.socketHeight.each(function (h) {
          $_bljwzsjcq8har2.set(platform.socket, 'height', h);
        });
        s.iframeHeight.each(function (h) {
          $_bljwzsjcq8har2.set(platform.editor.getFrame(), 'height', h);
        });
        document.body.scrollTop = s.scrollTop;
      });
      priorState.clear();
      scrollEvents.on(function (s) {
        s.exclusives.unbind();
      });
      scrollEvents.clear();
      $_waygfxujcq8hajt.remove(platform.container, $_30duqlz1jcq8haoh.resolve('fullscreen-maximized'));
      $_5bcj3p14gjcq8hbgf.restoreStyles();
      $_8r8euk13hjcq8hbbx.deregister(platform.toolbar);
      $_bljwzsjcq8har2.remove(platform.socket, 'overflow');
      $_bljwzsjcq8har2.remove(platform.socket, '-webkit-overflow-scrolling');
      $_dgsby1ygjcq8ham1.blur(platform.editor.getFrame());
      $_96mhb614fjcq8hbg0.getActiveApi(platform.editor).each(function (editorApi) {
        editorApi.clearSelection();
      });
    };
    var refreshStructure = function () {
      iosApi.run(function (api) {
        api.refreshStructure();
      });
    };
    return {
      enter: enter,
      refreshStructure: refreshStructure,
      exit: exit
    };
  };
  var $_aq4gc1159jcq8hbl3 = { create: create$7 };

  var produce$1 = function (raw) {
    var mobile = $_g540acxhjcq8hadd.asRawOrDie('Getting IosWebapp schema', MobileSchema, raw);
    $_bljwzsjcq8har2.set(mobile.toolstrip, 'width', '100%');
    $_bljwzsjcq8har2.set(mobile.container, 'position', 'relative');
    var onView = function () {
      mobile.setReadOnly(true);
      mode.enter();
    };
    var mask = $_1e8bjm12kjcq8hb5s.build($_7qdmx214jjcq8hbgv.sketch(onView, mobile.translate));
    mobile.alloy.add(mask);
    var maskApi = {
      show: function () {
        mobile.alloy.add(mask);
      },
      hide: function () {
        mobile.alloy.remove(mask);
      }
    };
    var mode = $_aq4gc1159jcq8hbl3.create(mobile, maskApi);
    return {
      setReadOnly: mobile.setReadOnly,
      refreshStructure: mode.refreshStructure,
      enter: mode.enter,
      exit: mode.exit,
      destroy: $_dh3z58wbjcq8ha9h.noop
    };
  };
  var $_7bp6jy158jcq8hbkz = { produce: produce$1 };

  var IosRealm = function (scrollIntoView) {
    var alloy = OuterContainer({ classes: [$_30duqlz1jcq8haoh.resolve('ios-container')] });
    var toolbar = ScrollingToolbar();
    var webapp = $_ffeym512ajcq8hb4a.api();
    var switchToEdit = $_gldja14rjcq8hbi6.makeEditSwitch(webapp);
    var socket = $_gldja14rjcq8hbi6.makeSocket();
    var dropup = $_b1805w14sjcq8hbic.build(function () {
      webapp.run(function (w) {
        w.refreshStructure();
      });
    }, scrollIntoView);
    alloy.add(toolbar.wrapper());
    alloy.add(socket);
    alloy.add(dropup.component());
    var setToolbarGroups = function (rawGroups) {
      var groups = toolbar.createGroups(rawGroups);
      toolbar.setGroups(groups);
    };
    var setContextToolbar = function (rawGroups) {
      var groups = toolbar.createGroups(rawGroups);
      toolbar.setContextToolbar(groups);
    };
    var focusToolbar = function () {
      toolbar.focus();
    };
    var restoreToolbar = function () {
      toolbar.restoreToolbar();
    };
    var init = function (spec) {
      webapp.set($_7bp6jy158jcq8hbkz.produce(spec));
    };
    var exit = function () {
      webapp.run(function (w) {
        Replacing.remove(socket, switchToEdit);
        w.exit();
      });
    };
    var updateMode = function (readOnly) {
      $_gldja14rjcq8hbi6.updateMode(socket, switchToEdit, readOnly, alloy.root());
    };
    return {
      system: $_dh3z58wbjcq8ha9h.constant(alloy),
      element: alloy.element,
      init: init,
      exit: exit,
      setToolbarGroups: setToolbarGroups,
      setContextToolbar: setContextToolbar,
      focusToolbar: focusToolbar,
      restoreToolbar: restoreToolbar,
      updateMode: updateMode,
      socket: $_dh3z58wbjcq8ha9h.constant(socket),
      dropup: $_dh3z58wbjcq8ha9h.constant(dropup)
    };
  };

  var EditorManager = tinymce.util.Tools.resolve('tinymce.EditorManager');

  var derive$4 = function (editor) {
    var base = $_f2tmkex6jcq8hach.readOptFrom(editor.settings, 'skin_url').fold(function () {
      return EditorManager.baseURL + '/skins/' + 'lightgray';
    }, function (url) {
      return url;
    });
    return {
      content: base + '/content.mobile.min.css',
      ui: base + '/skin.mobile.min.css'
    };
  };
  var $_yp7t015ujcq8hboc = { derive: derive$4 };

  var fontSizes = [
    'x-small',
    'small',
    'medium',
    'large',
    'x-large'
  ];
  var fireChange$1 = function (realm, command, state) {
    realm.system().broadcastOn([$_94pvbiyojcq8hamj.formatChanged()], {
      command: command,
      state: state
    });
  };
  var init$5 = function (realm, editor) {
    var allFormats = $_et458cx0jcq8hab6.keys(editor.formatter.get());
    $_dojsh2w9jcq8ha93.each(allFormats, function (command) {
      editor.formatter.formatChanged(command, function (state) {
        fireChange$1(realm, command, state);
      });
    });
    $_dojsh2w9jcq8ha93.each([
      'ul',
      'ol'
    ], function (command) {
      editor.selection.selectorChanged(command, function (state, data) {
        fireChange$1(realm, command, state);
      });
    });
  };
  var $_7vqndo15wjcq8hboe = {
    init: init$5,
    fontSizes: $_dh3z58wbjcq8ha9h.constant(fontSizes)
  };

  var fireSkinLoaded = function (editor) {
    var done = function () {
      editor._skinLoaded = true;
      editor.fire('SkinLoaded');
    };
    return function () {
      if (editor.initialized) {
        done();
      } else {
        editor.on('init', done);
      }
    };
  };
  var $_91pukc15xjcq8hboh = { fireSkinLoaded: fireSkinLoaded };

  var READING = $_dh3z58wbjcq8ha9h.constant('toReading');
  var EDITING = $_dh3z58wbjcq8ha9h.constant('toEditing');
  ThemeManager.add('mobile', function (editor) {
    var renderUI = function (args) {
      var cssUrls = $_yp7t015ujcq8hboc.derive(editor);
      if ($_6y1d3jynjcq8hami.isSkinDisabled(editor) === false) {
        editor.contentCSS.push(cssUrls.content);
        DOMUtils.DOM.styleSheetLoader.load(cssUrls.ui, $_91pukc15xjcq8hboh.fireSkinLoaded(editor));
      } else {
        $_91pukc15xjcq8hboh.fireSkinLoaded(editor)();
      }
      var doScrollIntoView = function () {
        editor.fire('scrollIntoView');
      };
      var wrapper = $_1t8d5wwtjcq8haao.fromTag('div');
      var realm = $_6a5cn8wgjcq8ha9o.detect().os.isAndroid() ? AndroidRealm(doScrollIntoView) : IosRealm(doScrollIntoView);
      var original = $_1t8d5wwtjcq8haao.fromDom(args.targetNode);
      $_1lvp6jy2jcq8hakj.after(original, wrapper);
      $_8oadbiy1jcq8haka.attachSystem(wrapper, realm.system());
      var findFocusIn = function (elem) {
        return $_dgsby1ygjcq8ham1.search(elem).bind(function (focused) {
          return realm.system().getByDom(focused).toOption();
        });
      };
      var outerWindow = args.targetNode.ownerDocument.defaultView;
      var orientation = $_fxqkqq13jjcq8hbc4.onChange(outerWindow, {
        onChange: function () {
          var alloy = realm.system();
          alloy.broadcastOn([$_94pvbiyojcq8hamj.orientationChanged()], { width: $_fxqkqq13jjcq8hbc4.getActualWidth(outerWindow) });
        },
        onReady: $_dh3z58wbjcq8ha9h.noop
      });
      var setReadOnly = function (readOnlyGroups, mainGroups, ro) {
        if (ro === false) {
          editor.selection.collapse();
        }
        realm.setToolbarGroups(ro ? readOnlyGroups.get() : mainGroups.get());
        editor.setMode(ro === true ? 'readonly' : 'design');
        editor.fire(ro === true ? READING() : EDITING());
        realm.updateMode(ro);
      };
      var bindHandler = function (label, handler) {
        editor.on(label, handler);
        return {
          unbind: function () {
            editor.off(label);
          }
        };
      };
      editor.on('init', function () {
        realm.init({
          editor: {
            getFrame: function () {
              return $_1t8d5wwtjcq8haao.fromDom(editor.contentAreaContainer.querySelector('iframe'));
            },
            onDomChanged: function () {
              return { unbind: $_dh3z58wbjcq8ha9h.noop };
            },
            onToReading: function (handler) {
              return bindHandler(READING(), handler);
            },
            onToEditing: function (handler) {
              return bindHandler(EDITING(), handler);
            },
            onScrollToCursor: function (handler) {
              editor.on('scrollIntoView', function (tinyEvent) {
                handler(tinyEvent);
              });
              var unbind = function () {
                editor.off('scrollIntoView');
                orientation.destroy();
              };
              return { unbind: unbind };
            },
            onTouchToolstrip: function () {
              hideDropup();
            },
            onTouchContent: function () {
              var toolbar = $_1t8d5wwtjcq8haao.fromDom(editor.editorContainer.querySelector('.' + $_30duqlz1jcq8haoh.resolve('toolbar')));
              findFocusIn(toolbar).each($_3yqf3awvjcq8haat.emitExecute);
              realm.restoreToolbar();
              hideDropup();
            },
            onTapContent: function (evt) {
              var target = evt.target();
              if ($_4z03v7xxjcq8hak1.name(target) === 'img') {
                editor.selection.select(target.dom());
                evt.kill();
              } else if ($_4z03v7xxjcq8hak1.name(target) === 'a') {
                var component = realm.system().getByDom($_1t8d5wwtjcq8haao.fromDom(editor.editorContainer));
                component.each(function (container) {
                  if (Swapping.isAlpha(container)) {
                    $_cwvd7vymjcq8hamh.openLink(target.dom());
                  }
                });
              }
            }
          },
          container: $_1t8d5wwtjcq8haao.fromDom(editor.editorContainer),
          socket: $_1t8d5wwtjcq8haao.fromDom(editor.contentAreaContainer),
          toolstrip: $_1t8d5wwtjcq8haao.fromDom(editor.editorContainer.querySelector('.' + $_30duqlz1jcq8haoh.resolve('toolstrip'))),
          toolbar: $_1t8d5wwtjcq8haao.fromDom(editor.editorContainer.querySelector('.' + $_30duqlz1jcq8haoh.resolve('toolbar'))),
          dropup: realm.dropup(),
          alloy: realm.system(),
          translate: $_dh3z58wbjcq8ha9h.noop,
          setReadOnly: function (ro) {
            setReadOnly(readOnlyGroups, mainGroups, ro);
          }
        });
        var hideDropup = function () {
          realm.dropup().disappear(function () {
            realm.system().broadcastOn([$_94pvbiyojcq8hamj.dropupDismissed()], {});
          });
        };
        $_dxnqasy8jcq8hal9.registerInspector('remove this', realm.system());
        var backToMaskGroup = {
          label: 'The first group',
          scrollable: false,
          items: [$_378a61z2jcq8haoj.forToolbar('back', function () {
              editor.selection.collapse();
              realm.exit();
            }, {})]
        };
        var backToReadOnlyGroup = {
          label: 'Back to read only',
          scrollable: false,
          items: [$_378a61z2jcq8haoj.forToolbar('readonly-back', function () {
              setReadOnly(readOnlyGroups, mainGroups, true);
            }, {})]
        };
        var readOnlyGroup = {
          label: 'The read only mode group',
          scrollable: true,
          items: []
        };
        var features = $_6ouiyjypjcq8hams.setup(realm, editor);
        var items = $_6ouiyjypjcq8hams.detect(editor.settings, features);
        var actionGroup = {
          label: 'the action group',
          scrollable: true,
          items: items
        };
        var extraGroup = {
          label: 'The extra group',
          scrollable: false,
          items: []
        };
        var mainGroups = Cell([
          backToReadOnlyGroup,
          actionGroup,
          extraGroup
        ]);
        var readOnlyGroups = Cell([
          backToMaskGroup,
          readOnlyGroup,
          extraGroup
        ]);
        $_7vqndo15wjcq8hboe.init(realm, editor);
      });
      return {
        iframeContainer: realm.socket().element().dom(),
        editorContainer: realm.element().dom()
      };
    };
    return {
      getNotificationManagerImpl: function () {
        return {
          open: $_dh3z58wbjcq8ha9h.identity,
          close: $_dh3z58wbjcq8ha9h.noop,
          reposition: $_dh3z58wbjcq8ha9h.noop,
          getArgs: $_dh3z58wbjcq8ha9h.identity
        };
      },
      renderUI: renderUI
    };
  });
  var Theme = function () {
  };

  return Theme;

}());
})()
