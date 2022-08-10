/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/components/Block/Block.js":
/*!***************************************!*\
  !*** ./src/components/Block/Block.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Block": () => (/* binding */ Block)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _BlockSettings_BlockSettings__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../BlockSettings/BlockSettings */ "./src/components/BlockSettings/BlockSettings.js");
/* harmony import */ var _Table_Table__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../Table/Table */ "./src/components/Table/Table.js");
/* harmony import */ var _Error_Error__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../Error/Error */ "./src/components/Error/Error.js");
/* harmony import */ var _Loading_Loading__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../Loading/Loading */ "./src/components/Loading/Loading.js");






const Block = _ref => {
  let {
    attributes,
    setAttributes
  } = _ref;
  const {
    adminVars,
    error,
    data,
    hiddenColumns
  } = attributes;

  const setHiddenColumns = hiddenColumns => {
    setAttributes({
      hiddenColumns
    });
  };

  const render = () => {
    if (!!error) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_Error_Error__WEBPACK_IMPORTED_MODULE_4__.Error, {
        error: error
      });
    }

    if (!!data) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_Table_Table__WEBPACK_IMPORTED_MODULE_3__.Table, {
        data: data,
        hiddenColumns: hiddenColumns
      });
    }

    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_Loading_Loading__WEBPACK_IMPORTED_MODULE_5__.Loading, null);
  };

  if (!data) {
    jQuery.post(adminVars.url, {
      action: adminVars.action,
      wpnonce: adminVars.nonce
    }, _ref2 => {
      let {
        data,
        success
      } = _ref2;

      if (!success) {
        return setAttributes({
          error: data.errorMessage
        });
      }

      setAttributes({
        data
      });
    });
  }

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.InspectorControls, {
    key: "setting"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_BlockSettings_BlockSettings__WEBPACK_IMPORTED_MODULE_2__.BlockSettings, {
    hiddenColumns: hiddenColumns,
    setHiddenColumns: setHiddenColumns
  })), render());
};

/***/ }),

/***/ "./src/components/BlockSettings/BlockSettings.js":
/*!*******************************************************!*\
  !*** ./src/components/BlockSettings/BlockSettings.js ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "BlockSettings": () => (/* binding */ BlockSettings)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);


const BlockSettings = _ref => {
  let {
    hiddenColumns,
    setHiddenColumns
  } = _ref;

  const _hiddenColumns = hiddenColumns || {};

  const hideID = _hiddenColumns.id ? true : false;
  const hideFname = _hiddenColumns.fname ? true : false;
  const hideLname = _hiddenColumns.lname ? true : false;
  const hideEmail = _hiddenColumns.email ? true : false;
  const hideDate = _hiddenColumns.date ? true : false;
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "block-settings"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.ToggleControl, {
    label: "Hide ID",
    help: hideID ? 'Hidden' : 'Visible.',
    checked: !hideID,
    onChange: checked => {
      if (checked) {
        delete _hiddenColumns.id;
      } else {
        _hiddenColumns.id = 'ID';
      }

      setHiddenColumns({ ..._hiddenColumns
      });
    }
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.ToggleControl, {
    label: "Hide First Name",
    help: hideFname ? 'Hidden' : 'Visible.',
    checked: !hideFname,
    onChange: checked => {
      if (checked) {
        delete _hiddenColumns.fname;
      } else {
        _hiddenColumns.fname = 'First Name';
      }

      setHiddenColumns({ ..._hiddenColumns
      });
    }
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.ToggleControl, {
    label: "Hide Last Name",
    help: hideLname ? 'Hidden' : 'Visible',
    checked: !hideLname,
    onChange: checked => {
      if (checked) {
        delete _hiddenColumns.lname;
      } else {
        _hiddenColumns.lname = 'Last Name';
      }

      setHiddenColumns({ ..._hiddenColumns
      });
    }
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.ToggleControl, {
    label: "Hide Email",
    help: hideEmail ? 'Hidden' : 'Visible',
    checked: !hideEmail,
    onChange: checked => {
      if (checked) {
        delete _hiddenColumns.email;
      } else {
        _hiddenColumns.email = 'Email';
      }

      setHiddenColumns({ ..._hiddenColumns
      });
    }
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.ToggleControl, {
    label: "Hide Date",
    help: hideDate ? 'Hidden' : 'Visible',
    checked: !hideDate,
    onChange: checked => {
      if (checked) {
        delete _hiddenColumns.date;
      } else {
        _hiddenColumns.date = 'Date';
      }

      setHiddenColumns({ ..._hiddenColumns
      });
    }
  }));
};

/***/ }),

/***/ "./src/components/Error/Error.js":
/*!***************************************!*\
  !*** ./src/components/Error/Error.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Error": () => (/* binding */ Error)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);

const Error = () => {
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, "Error");
};

/***/ }),

/***/ "./src/components/Loading/Loading.js":
/*!*******************************************!*\
  !*** ./src/components/Loading/Loading.js ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Loading": () => (/* binding */ Loading)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);

const Loading = () => {
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, "Loading");
};

/***/ }),

/***/ "./src/components/Table/Table.js":
/*!***************************************!*\
  !*** ./src/components/Table/Table.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Table": () => (/* binding */ Table)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);


/*
    {
        hiddenColumns: {
            fname: "First Name"
        }
    }

*/
const Table = _ref => {
  let {
    data,
    hiddenColumns
  } = _ref;
  const {
    title,
    data: table
  } = data;

  const _hiddenColumns = hiddenColumns || {};

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h4", null, title), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("table", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("thead", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("tr", null, table.headers.filter(col => !Object.values(_hiddenColumns).includes(col)).map(col => {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("th", null, col);
  }))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("tbody", null, Object.values(table.rows).map(row => {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("tr", null, Object.entries(row).filter(_ref2 => {
      let [key, value] = _ref2;
      return !Object.keys(_hiddenColumns).includes(key);
    }).map(_ref3 => {
      let [key, value] = _ref3;
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("td", null, value);
    }));
  }))));
};

/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ ((module) => {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ ((module) => {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["element"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _components_Block_Block__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./components/Block/Block */ "./src/components/Block/Block.js");
/* harmony import */ var _components_Table_Table__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./components/Table/Table */ "./src/components/Table/Table.js");





(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__.registerBlockType)('am-apiplugin/am-apiblock', {
  edit: _ref => {
    let {
      attributes,
      setAttributes
    } = _ref;
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.useBlockProps)(), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_Block_Block__WEBPACK_IMPORTED_MODULE_3__.Block, {
      attributes: attributes,
      setAttributes: setAttributes
    }));
  },
  save: _ref2 => {
    let {
      attributes
    } = _ref2;
    const {
      data,
      hiddenColumns
    } = attributes;
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.useBlockProps.save(), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_Table_Table__WEBPACK_IMPORTED_MODULE_4__.Table, {
      data: data,
      hiddenColumns: hiddenColumns
    }));
  }
});
})();

/******/ })()
;
//# sourceMappingURL=index.js.map