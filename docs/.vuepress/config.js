import { viteBundler } from '@vuepress/bundler-vite'
import { defaultTheme } from '@vuepress/theme-default'
import { defineUserConfig } from 'vuepress'
import { searchPlugin } from '@vuepress/plugin-search'
import { shikiPlugin } from '@vuepress/plugin-shiki'
import matomoPlugin from 'vuepress-plugin-matomo'

const isProd = process.env.NODE_ENV === 'production'

export default defineUserConfig({
  bundler: viteBundler(),
  theme: defaultTheme({
    navbar: [
      // { text: 'Installation', link: '/#installation-setup' },
      // { text: 'Usage', link: '/usage.html' },
      // { text: 'Examples', link: '/example.html' },
      { text: 'Author', link: 'https://jakobosterberger.com' },
      { text: 'Blog', link: 'https://jakobosterberger.com/posts' }
    ],

    repo: 'jk-oster/laravel-collection-trend',
    docsBranch: 'gh-pages',
    docsDir: './docs',
    editLink: true,
    editLinkText: 'Edit this page on GitHub',
    sidebarDepth: 2,
    sidebar: [
      '/README.md',
      '/usage.md',
      '/example.md',
    ],
    home: '/',
    colorMode: 'auto',

    themePlugins: {
      // only enable git plugin in production mode
      git: isProd,
      // use shiki plugin in production mode instead
      prismjs: !isProd,
    },
  }),

  lang: 'en-US',
  title: 'Collection Trend for Laravel',
  description: 'Generate trends from collections. Easily create charts or reports.',
  base: '/laravel-collection-trend/',

  plugins: [
    searchPlugin(),

    matomoPlugin({
      siteId: '4',
      url: 'https://matomo.caprover.jkoster.com/',
    }),

    // only enable shiki plugin in production mode
    isProd
      ? shikiPlugin({
          langs: ['bash', 'diff', 'json', 'md', 'ts', 'vue', 'php'],
          theme: 'dark-plus',
        })
      : [],
  ],
});
