import globals from "globals";
import pluginJs from "@eslint/js";
import pluginVue from "eslint-plugin-vue";

export default [
  {
    files: ["**/*.{js,mjs,cjs,vue}"],
    languageOptions: {
      ecmaVersion: 2021, // Ensures compatibility with modern JS features
      sourceType: "module", // Allows the use of import/export statements
      globals: globals.browser,
    },
    plugins: {
      vue: pluginVue,
    },
    rules: {
      ...pluginJs.configs.recommended.rules,
      ...pluginVue.configs["flat/essential"].rules,
    },
  },
];


