module.exports = {
  root: true,
  env: {
    node: true,
  },
  extends: [
    'plugin:vue/essential',
    'airbnb-base',
  ],
  rules: {
    // not supports aliases
    'import/no-unresolved':0,
    'import/extensions': 0,
    'import/no-extraneous-dependencies': 0,

    'no-console': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
  },
  parserOptions: {
    parser: 'babel-eslint',
  },
};
