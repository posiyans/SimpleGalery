<template>
  <q-scroll-area class="fit">
    <q-list>
      <template
        v-for="(menuItem, index) in menuList"
        :key="index"
      >
        <q-item
          v-ripple
          clickable
          @click="openUrl(menuItem.url)"
        >
          <q-item-section avatar>
            <q-icon :name="menuItem.icon" />
          </q-item-section>
          <q-item-section>
            {{ menuItem.label }}
          </q-item-section>
        </q-item>
        <q-separator
          v-if="menuItem.separator"
          :key="'sep' + index"
        />
      </template>
    </q-list>
  </q-scroll-area>
</template>

<script>
export default {
  data() {
    return {
      menuList: [
        {
          icon: 'inbox',
          label: 'Галерея',
          url: '/media',
          separator: true
        },
        {
          icon: 'send',
          label: 'Outbox',
          separator: false
        },
        {
          icon: 'delete',
          label: 'Trash',
          separator: false
        },
        {
          icon: 'error',
          label: 'Spam',
          separator: true
        },
        {
          icon: 'settings',
          label: 'Настройки',
          separator: false
        },
        {
          icon: 'feedback',
          label: 'Папки',
          url: '/settings/media/folders',
          separator: false
        },
        {
          icon: 'help',
          iconColor: 'primary',
          label: 'Help',
          separator: false
        }
      ]
    }
  },
  mounted() {
    const route = this.$route
    console.log('route')
    console.log(route)
  },
  methods: {
    openUrl(url) {
      if (url) {
        this.$router.push(url)
      }
    }
  }
}
</script>

<style scoped>

</style>
