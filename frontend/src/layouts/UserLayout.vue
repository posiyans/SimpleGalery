<template>
  <q-layout view="lhh Lpr lFf">
    <Header />
    <Drawer />
    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import { defineComponent } from 'vue'
import Header from 'layouts/components/Header'
import Drawer from 'layouts/components/Drawer'

export default defineComponent({
  name: 'MainLayout',
  components: {
    Header,
    Drawer
  }
})
</script>
