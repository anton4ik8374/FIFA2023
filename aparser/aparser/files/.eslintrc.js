module.exports = {
  root: true,
  parser: '@typescript-eslint/parser',
  plugins: [
    '@typescript-eslint',
  ],
  extends: [
    //'eslint:recommended',
    //'plugin:@typescript-eslint/recommended',
  ],
  rules: {
    "@typescript-eslint/no-floating-promises": "error",
  },
  parserOptions: {
    "ecmaVersion": "ESNext",
    "sourceType": "module",
  },
  overrides: [
    {
      files: ['*.ts'],
      parserOptions: {
        project: ['./tsconfig.json'],
        tsconfigRootDir: __dirname,
      },
    },
  ],
};