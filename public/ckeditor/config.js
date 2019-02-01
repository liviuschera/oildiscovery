/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function(config) {
   // Define changes to default configuration here.
   // For complete reference see:
   // http://docs.ckeditor.com/#!/api/CKEDITOR.config

   // The toolbar groups arrangement, optimized for two toolbar rows.
   config.toolbarGroups = [
      { name: "clipboard", groups: ["clipboard", "undo"] },
      { name: "editing", groups: ["find", "selection", "spellchecker"] },
      { name: "links" },
      { name: "insert" },
      { name: "forms" },
      { name: "tools" },
      { name: "document", groups: ["mode", "document", "doctools"] },
      { name: "others" },
      "/",
      { name: "basicstyles", groups: ["basicstyles", "cleanup"] },
      {
         name: "paragraph",
         groups: ["list", "indent", "blocks", "align", "bidi"]
      },
      { name: "styles" },
      { name: "colors" },
      { name: "about" }
   ];

   // Remove some buttons provided by the standard plugins, which are
   // not needed in the Standard(s) toolbar.
   config.removeButtons = "Underline,Subscript,Superscript";

   // Set the most common block elements.
   config.format_tags = "p;h1;h2;h3;pre";

   // Simplify the dialog windows.
   config.removeDialogTabs = "image:advanced;link:advanced";
   // config.fontSize_defaultLabel = "14px";
   // config.font_style = {
   //    element: "p",
   //    styles: { "font-family": "#Oregano" },
   //    overrides: [{ element: "font", attributes: { face: null } }]
   // };
   // config.fontSize_sizes = "14px;2.3em;130%;larger;x-small";
   // config.fontSize_sizes =
   //    "10rem;12rem;14rem;16rem;18rem;20rem;22rem;24rem;26rem;28rem;30rem;";
   config.font_names = "Open Sans;Oregano";
   config.contentsCss = "../css/styles.css";
};
