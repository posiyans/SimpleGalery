v<template>
  <q-uploader
    ref="uploadform"
    :url="url"
    label="Добавить файл"
    multiple
    auto-upload
    :headers="headers"
    :form-fields="field"
    with-credentials
    field-name="media-file"
    style="width: 600px; max-width: 100%;"
    @uploaded="finish"
  >
    <template v-slot:list="scope">
      <q-list separator style="min-height: 250px;height: 100%">

        <q-item v-for="file in scope.files" :key="file.__key">
          <q-item-section>
            <q-item-label class="full-width ellipsis">
              {{ file.name }}
            </q-item-label>

            <q-item-label caption>
              File: {{ file.__sizeLabel }} / {{ file.__status }}
            </q-item-label>

            <q-item-label caption>
              <ProgressBar
                v-if="file.__progressLabel"
                :progress="file.__progressLabel"
                :status="file.__status"
              />
            </q-item-label>
          </q-item-section>

          <q-item-section top side>
            <q-btn
              class="gt-xs"
              size="12px"
              flat
              dense
              round
              icon="delete"
              @click="scope.removeFile(file)"
            />
          </q-item-section>
        </q-item>
      </q-list>
    </template>
  </q-uploader>
</template>

<script>

import { LocalStorage, Cookies } from 'quasar'
import { getCsrfCookie } from 'src/modules/Auth/api/token'
import ProgressBar from 'components/ProgressBar'

export default {
  components: {
    ProgressBar
  },
  props: {
    galleryId: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      formAddShow: false,
      selected: '',
      list: [],
      showImage: true,
      slide: 'first',
      dialog: false,
      index: null,
      headers: [],
      field: [],
      timer: false
    }
  },
  computed: {
    url() {
      return process.env.BASE_API + '/api/v1/medial/folders/upload-image-in-gallery'
    }
  },
  mounted() {
    getCsrfCookie()
      .then(() => {
        const value = Cookies.get('XSRF-TOKEN')
        this.headers.push({ name: 'X-XSRF-TOKEN', value })
        Cookies.set('X-XSRF-TOKEN', value)
        Cookies.set('XSRF-TOKEN', value)
      })
    const token = LocalStorage.getItem('user_token')
    this.headers.push({ name: 'Authorization', value: 'Bearer ' + token })
    // this.headers.push({ name: 'Accept', value: 'application/json, text/plain, */*' })
    this.field.push({ name: 'gallery', value: this.galleryId })
  },
  methods: {
    finish() {
      this.$refs.uploadform.removeUploadedFiles()
      if (!this.timer) {
        this.timer = setTimeout(() => {
          this.$emit('reload')
          this.timer = false
        }, 500)
      }
    }

  }
}
</script>

<style scoped lang="scss">

</style>
