(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[3],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Berita/BeritaArsip.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Berita/BeritaArsip.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      beritas: {}
    };
  },
  mounted: function mounted() {
    this.loadBerita();
  },
  methods: {
    loadBerita: function loadBerita() {
      var _this = this;

      axios__WEBPACK_IMPORTED_MODULE_0___default.a.get("post/showRandom").then(function (response) {
        _this.beritas = response.data.data;
      })["catch"](function (error) {
        _this.$notify({
          group: "error",
          title: "Gagal",
          text: "ERROR : " + error.message,
          type: "error" //nilai lain, error dan success

        });
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Berita/BeritaArsip.vue?vue&type=template&id=b5b0f476&":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/Berita/BeritaArsip.vue?vue&type=template&id=b5b0f476& ***!
  \*********************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "v-layout",
    { attrs: { row: "" } },
    _vm._l(_vm.beritas, function(berita, index) {
      return _c(
        "v-flex",
        {
          key: index,
          staticClass: "mb-2 px-1",
          attrs: { xs12: "", sm4: "", md3: "" }
        },
        [
          _c("v-divider", { attrs: { inset: "" } }),
          _vm._v(" "),
          _c(
            "v-list-item",
            { attrs: { route: "", to: "/berita/" + berita.berita.slug } },
            [
              _c(
                "v-list-item-avatar",
                [
                  _c("v-img", {
                    attrs: {
                      src: "https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "v-list-item-content",
                [
                  _c("v-list-item-title", {
                    domProps: { innerHTML: _vm._s(berita.berita.judul) }
                  }),
                  _vm._v(" "),
                  _c("v-list-item-subtitle", {
                    staticClass: "caption font-weight-thin",
                    domProps: { innerHTML: _vm._s(berita.berita.deskripsi) }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "v-list-item-action",
                [
                  _c("v-list-item-action-text", { staticClass: "caption " }, [
                    _vm._v(_vm._s(_vm._f("formatMonth")(berita.created_at)))
                  ]),
                  _vm._v(" "),
                  _c(
                    "v-badge",
                    {
                      attrs: { inline: "", overlap: "", color: "info" },
                      scopedSlots: _vm._u(
                        [
                          {
                            key: "badge",
                            fn: function() {
                              return [_c("v-icon", [_vm._v("mdi-eye-outline")])]
                            },
                            proxy: true
                          }
                        ],
                        null,
                        true
                      )
                    },
                    [
                      _vm._v(" "),
                      [
                        _c("v-list-item-subtitle", {
                          staticClass: "caption font-weight-thin",
                          attrs: { color: "white" },
                          domProps: { innerHTML: _vm._s(berita.views) }
                        })
                      ]
                    ],
                    2
                  )
                ],
                1
              )
            ],
            1
          )
        ],
        1
      )
    }),
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/Berita/BeritaArsip.vue":
/*!********************************************************!*\
  !*** ./resources/js/components/Berita/BeritaArsip.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _BeritaArsip_vue_vue_type_template_id_b5b0f476___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./BeritaArsip.vue?vue&type=template&id=b5b0f476& */ "./resources/js/components/Berita/BeritaArsip.vue?vue&type=template&id=b5b0f476&");
/* harmony import */ var _BeritaArsip_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./BeritaArsip.vue?vue&type=script&lang=js& */ "./resources/js/components/Berita/BeritaArsip.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _BeritaArsip_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _BeritaArsip_vue_vue_type_template_id_b5b0f476___WEBPACK_IMPORTED_MODULE_0__["render"],
  _BeritaArsip_vue_vue_type_template_id_b5b0f476___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/Berita/BeritaArsip.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/Berita/BeritaArsip.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/Berita/BeritaArsip.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_BeritaArsip_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./BeritaArsip.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Berita/BeritaArsip.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_BeritaArsip_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/Berita/BeritaArsip.vue?vue&type=template&id=b5b0f476&":
/*!***************************************************************************************!*\
  !*** ./resources/js/components/Berita/BeritaArsip.vue?vue&type=template&id=b5b0f476& ***!
  \***************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_BeritaArsip_vue_vue_type_template_id_b5b0f476___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./BeritaArsip.vue?vue&type=template&id=b5b0f476& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/Berita/BeritaArsip.vue?vue&type=template&id=b5b0f476&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_BeritaArsip_vue_vue_type_template_id_b5b0f476___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_BeritaArsip_vue_vue_type_template_id_b5b0f476___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);