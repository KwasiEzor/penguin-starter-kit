import { defineConfig } from 'vitepress'

export default defineConfig({
  title: 'Penguin Starter Kit',
  description: 'A production-ready Laravel 12 starter kit for building modern SaaS applications.',
  base: '/penguin-starter-kit/',

  head: [
    ['link', { rel: 'icon', type: 'image/svg+xml', href: '/penguin-starter-kit/favicon.svg' }],
    ['meta', { name: 'theme-color', content: '#6366f1' }],
    ['meta', { property: 'og:type', content: 'website' }],
    ['meta', { property: 'og:title', content: 'Penguin Starter Kit' }],
    ['meta', { property: 'og:description', content: 'A production-ready Laravel 12 starter kit for building modern SaaS applications.' }],
    ['meta', { property: 'og:url', content: 'https://kwasiezor.github.io/penguin-starter-kit/' }],
  ],

  themeConfig: {
    logo: '/logo.svg',
    siteTitle: 'Penguin Starter Kit',

    nav: [
      { text: 'Guide', link: '/guide/introduction', activeMatch: '/guide/' },
      { text: 'Features', link: '/features/authentication', activeMatch: '/features/' },
      { text: 'UI', link: '/ui/overview', activeMatch: '/ui/' },
      { text: 'Reference', link: '/reference/routes', activeMatch: '/reference/' },
      {
        text: 'v1.x',
        items: [
          { text: 'Changelog', link: '/guide/changelog' },
          { text: 'Contributing', link: '/guide/contributing' },
        ],
      },
    ],

    sidebar: {
      '/guide/': [
        {
          text: 'Getting Started',
          items: [
            { text: 'Introduction', link: '/guide/introduction' },
            { text: 'Quick Start', link: '/guide/quick-start' },
            { text: 'Configuration', link: '/guide/configuration' },
            { text: 'Project Structure', link: '/guide/project-structure' },
          ],
        },
        {
          text: 'Going Further',
          items: [
            { text: 'Customization', link: '/guide/customization' },
            { text: 'Deployment', link: '/guide/deployment' },
            { text: 'Testing', link: '/guide/testing' },
          ],
        },
        {
          text: 'About',
          items: [
            { text: 'Changelog', link: '/guide/changelog' },
            { text: 'Contributing', link: '/guide/contributing' },
          ],
        },
      ],

      '/features/': [
        {
          text: 'Core Features',
          items: [
            { text: 'Authentication', link: '/features/authentication' },
            { text: 'Posts & Blog', link: '/features/posts-blog' },
            { text: 'AI Agents', link: '/features/ai-agents' },
            { text: 'Admin Dashboard', link: '/features/admin-dashboard' },
            { text: 'Roles & Permissions', link: '/features/roles-permissions' },
          ],
        },
        {
          text: 'Integrations',
          items: [
            { text: 'Payments', link: '/features/payments' },
            { text: 'Notifications', link: '/features/notifications' },
            { text: 'REST API', link: '/features/api' },
            { text: 'Spotlight Search', link: '/features/search' },
            { text: 'User Settings', link: '/features/settings' },
          ],
        },
      ],

      '/ui/': [
        {
          text: 'Design System',
          items: [
            { text: 'Overview', link: '/ui/overview' },
            { text: 'Components', link: '/ui/components' },
            { text: 'Layouts', link: '/ui/layouts' },
            { text: 'Dark Mode', link: '/ui/dark-mode' },
            { text: 'Theme Presets', link: '/ui/theme-presets' },
          ],
        },
      ],

      '/reference/': [
        {
          text: 'Reference',
          items: [
            { text: 'Routes', link: '/reference/routes' },
            { text: 'Architecture', link: '/reference/architecture' },
            { text: 'Security', link: '/reference/security' },
            { text: 'CI/CD', link: '/reference/ci-cd' },
          ],
        },
      ],
    },

    socialLinks: [
      { icon: 'github', link: 'https://github.com/kwasiezor/penguin-starter-kit' },
    ],

    editLink: {
      pattern: 'https://github.com/kwasiezor/penguin-starter-kit/edit/main/docs/:path',
      text: 'Edit this page on GitHub',
    },

    footer: {
      message: 'Released under the MIT License.',
      copyright: 'Copyright &copy; 2024-present kwasiezor',
    },

    search: {
      provider: 'local',
    },

    lastUpdated: {
      text: 'Updated at',
      formatOptions: {
        dateStyle: 'short',
        timeStyle: 'short',
      },
    },
  },

  lastUpdated: true,

  srcExclude: ['**/MILESTONE*.md'],
})
