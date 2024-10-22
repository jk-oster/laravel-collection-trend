import { viteBundler } from '@vuepress/bundler-vite'
import { defaultTheme } from '@vuepress/theme-default'
import { defineUserConfig } from 'vuepress'

export default defineUserConfig({
  bundler: viteBundler(),
  theme: defaultTheme({
    navbar: [
      { text: 'GitHub', link: 'https://github.com/jk-oster/laravel-collection-trend' },
      { text: 'Author', link: 'https://jakobosterberger.com' },
      { text: 'Blog', link: 'https://jakobosterberger.com/posts' }
    ]
  }),

  lang: 'en-US',
  title: 'Collection Trend for Laravel',
  description: 'Generate trends from collections. Easily create charts or reports.',
  base: '/laravel-collection-trend/',
});
