<template>
  <div class="column q-pa-lg items-center">
    <div class="row">
      <q-card
        square
        class="shadow-24"
        style="width:400px;height:540px;"
      >
        <q-card-section class="bg-deep-purple-7">
          <h4 class="text-h5 text-white q-my-md">
            {{ title }}
          </h4>
        </q-card-section>
        <q-card-section>
          <q-fab
            color="primary"
            icon="add"
            class="absolute"
            style="top: 0; right: 12px; transform: translateY(-50%);"
            @click="switchTypeForm"
          >
            <q-tooltip>
              Регистрация нового пользователя
            </q-tooltip>
          </q-fab>
          <q-form class="q-px-sm q-pt-xl">
            <q-input
              v-if="register"
              ref="email"
              v-model="email"
              square
              clearable
              type="email"
              lazy-rules=""
              :rules="[required, isEmail, short]"
              label="Email"
            >
              <template #prepend>
                <q-icon name="email" />
              </template>
            </q-input>
            <q-input
              ref="name"
              v-model="name"
              square
              clearable
              lazy-rules
              :rules="[required,short]"
              type="username"
              label="Пользователь"
            >
              <template #prepend>
                <q-icon name="person" />
              </template>
            </q-input>
            <q-input
              ref="password"
              v-model="password"
              square
              clearable
              :type="passwordFieldType"
              lazy-rules
              :rules="[required,short]"
              label="Пароль"
            >
              <template #prepend>
                <q-icon name="lock" />
              </template>
              <template #append>
                <q-icon
                  :name="visibilityIcon"
                  class="cursor-pointer"
                  @click="switchVisibility"
                />
              </template>
            </q-input>
            <q-input
              v-if="register"
              ref="repassword"
              v-model="repassword"
              square
              clearable
              :type="passwordFieldType"
              lazy-rules
              :rules="[required,short,diffPassword]"
              label="Повторить пароль"
            >
              <template #prepend>
                <q-icon name="lock" />
              </template>
              <template #append>
                <q-icon
                  :name="visibilityIcon"
                  class="cursor-pointer"
                  @click="switchVisibility"
                />
              </template>
            </q-input>
          </q-form>
        </q-card-section>

        <q-card-actions class="q-px-lg">
          <q-btn
            unelevated
            size="lg"
            :loading="loading"
            color="secondary"
            class="full-width text-white"
            :label="btnLabel"
            @click="submit"
          />
        </q-card-actions>
        <q-card-section
          v-if="!register"
          class="text-center q-pa-sm"
        >
          <p class="text-grey-6">
            Забыли пароль?
          </p>
        </q-card-section>
      </q-card>
    </div>
  </div>
</template>

<script>

export default {
  data () {
    return {
      redirect: undefined,
      otherQuery: {},
      loading: false,
      title: 'Авторизация',
      email: 'posiyans@yandex.ru',
      name: 'posiyans',
      password: '12345678',
      repassword: '12345678',
      register: false,
      passwordFieldType: 'password',
      btnLabel: 'Вход',
      visibility: false,
      visibilityIcon: 'visibility'
    }
  },
  watch: {
    $route: {
      handler: function(route) {
        const query = route.query
        if (query) {
          this.redirect = query.redirect
          this.otherQuery = this.getOtherQuery(query)
        }
      },
      immediate: true
    }
  },
  methods: {
    getOtherQuery(query) {
      return Object.keys(query).reduce((acc, cur) => {
        if (cur !== 'redirect') {
          acc[cur] = query[cur]
        }
        return acc
      }, {})
    },
    required (val) {
      return ((val && val.length > 0) || 'Поле должно быть заполнено')
    },
    diffPassword (val) {
      return ((val && val === this.password) || 'Пароль не совпадает!')
    },
    short (val) {
      return ((val && val.length > 3) || 'Значение слишком короткое')
    },
    isEmail (val) {
      const emailPattern = /^(?=[a-zA-Z0-9@._%+-]{6,254}$)[a-zA-Z0-9._%+-]{1,64}@(?:[a-zA-Z0-9-]{1,63}\.){1,8}[a-zA-Z]{2,63}$/
      return (emailPattern.test(val) || 'Введите корректный email')
    },
    async submit () {
      if (this.register) {
        this.$refs.email.validate()
        this.$refs.name.validate()
        this.$refs.password.validate()
        this.$refs.repassword.validate()
      } else {
        this.$refs.name.validate()
        this.$refs.password.validate()
      }

      if (this.register) {
        const data = {
          email: this.email,
          password: this.password,
          name: this.name,
          password_confirmation: this.repassword
        }
        const { role } = await this.$store.dispatch('user/register', data)
        if (role !== 'guest') {
          this.$router.push('/')
        }
      } else {
        if (!this.$refs.name.hasError && (!this.$refs.password.hasError)) {
          this.loading = true
          const data = {
            name: this.name,
            password: this.password,
            remember: true
          }
          this.$store.dispatch('user/login', data)
            .then(() => {
              this.$router.push({ path: this.redirect || '/', query: this.otherQuery })
              this.loading = false
            })
            .catch(() => {
              this.loading = false
            })
        }
      }
    },
    switchTypeForm () {
      this.register = !this.register
      this.title = this.register ? 'Новый пользователь' : 'Авторизация'
      this.btnLabel = this.register ? 'Регистрация' : 'Вход'
    },
    switchVisibility () {
      this.visibility = !this.visibility
      this.passwordFieldType = this.visibility ? 'text' : 'password'
      this.visibilityIcon = this.visibility ? 'visibility_off' : 'visibility'
    }
  }
}
</script>

<style scoped>

</style>
