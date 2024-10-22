import { viteBundler } from '@vuepress/bundler-vite'
import { defaultTheme } from '@vuepress/theme-default'
import { defineUserConfig } from 'vuepress'

export default defineUserConfig({
  bundler: viteBundler(),
  theme: defaultTheme({
    navbar: [
      { text: 'Installation', link: '/#installation-setup' },
      { text: 'Usage', link: '/usage.html' },
      { text: 'Examples', link: '/example.html' },
      { text: 'Author', link: 'https://jakobosterberger.com' },
      { text: 'Blog', link: 'https://jakobosterberger.com/posts' }
    ],

    repo: 'jk-oster/laravel-collection-trend',
    docsBranch: 'gh-pages',
    docsDir: './docs',
    editLink: true,
    sidebarDepth: 2,
    sidebar: 'heading',
    home: '/',
    colorMode: 'auto',
  }),

  lang: 'en-US',
  title: 'Collection Trend for Laravel',
  description: 'Generate trends from collections. Easily create charts or reports.',
  base: '/laravel-collection-trend/',
});
