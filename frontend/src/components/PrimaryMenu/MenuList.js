const menuList = [
  {
    icon: 'inbox',
    label: 'Галереи',
    url: '/gallery-list',
    separator: true
  },
  {
    icon: 'settings',
    label: 'Настройки',
    url: '/settings/media/folders',
    roles: ['admin'],
    separator: false
  },
  {
    icon: 'settings',
    label: 'Настройки2',
    url: '/settings/gallery',
    roles: ['admin'],
    separator: false
  },
  {
    icon: 'help',
    iconColor: 'primary',
    url: '/settings/help',
    label: 'Help',
    separator: false
  }
]

export { menuList }
