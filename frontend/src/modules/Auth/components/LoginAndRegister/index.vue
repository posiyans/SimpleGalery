<template>
  <q-card
    square
    class="shadow-24 q-pa-sm"
    style="max-width:400px;"
  >
    <q-form
      class="q-gutter-md"
      @submit="submit"
    >
      <q-card-section class="bg-deep-purple-7">
        <h4 class="text-h5 text-white q-my-md">
          {{ title }}
        </h4>
      </q-card-section>
      <q-card-section>
        <q-fab
          v-if="regEnable"
          color="primary"
          icon="add"
          class="absolute"
          style="top: 0; right: 12px; transform: translateY(-45px);"
          @click="switchTypeForm"
        >
          <q-tooltip>
            Регистрация нового пользователя
          </q-tooltip>
        </q-fab>
        <q-form class="q-px-sm q-pt-xl">
          <q-input
            ref="refsEmail"
            v-model="user.email"
            square
            type="email"
            lazy-rules=""
            :rules="[required, isEmail, short]"
            label="Email"
          >
            <template #prepend>
              <q-icon name="email"/>
            </template>
          </q-input>
          <q-input
            v-if="registration"
            ref="refsName"
            v-model="user.name"
            square
            lazy-rules
            :rules="[required,short]"
            type="username"
            label="Пользователь"
          >
            <template #prepend>
              <q-icon name="person"/>
            </template>
          </q-input>
          <q-input
            ref="refsPassword"
            v-model="user.password"
            square
            :type="passwordFieldType"
            lazy-rules
            :rules="[required,short]"
            label="Пароль"
          >
            <template #prepend>
              <q-icon name="lock"/>
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
            v-if="registration"
            ref="refsConfirmPassword"
            v-model="user.password_confirmation"
            square
            :type="passwordFieldType"
            lazy-rules
            :rules="[required,short,diffPassword]"
            label="Повторить пароль"
          >
            <template #prepend>
              <q-icon name="lock"/>
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

      <q-card-actions class="q-pa-lg">
        <q-btn
          unelevated
          size="lg"
          :loading="loading"
          type="submit"
          no-caps
          color="secondary"
          class="full-width text-white"
          :label="btnLabel"
        />
      </q-card-actions>
      <q-card-section
        v-if="!registration"
        class="text-center q-pa-sm"
      >
        <p class="text-grey-6">
          Забыли пароль?
        </p>
      </q-card-section>
    </q-form>
  </q-card>
</template>

<script>
import { useRouter, useRoute } from 'vue-router'
import { required, short, isEmail } from 'src/hooks/validate'
import { useStore } from 'vuex'
import { registration, title, btnLabel, switchTypeForm } from './hooks/form'
import { passwordFieldType, visibilityIcon, switchVisibility } from './hooks/passwordVisible'
import { userForm } from 'src/modules/Auth/components/LoginAndRegister/hooks/userForm'

export default {
  setup() {
    const router = useRouter()
    const route = useRoute()
    const store = useStore()
    const { submit, user, diffPassword, loading, checkRegToken, regEnable } = userForm(store, router)
    checkRegToken(route.query.token && route.query.token)
    return {
      title,
      registration,
      btnLabel,
      switchTypeForm,
      switchVisibility,
      visibilityIcon,
      passwordFieldType,
      required,
      diffPassword,
      short,
      isEmail,
      user,
      loading,
      submit,
      regEnable
    }
  }
}
</script>

<style scoped>

</style>
