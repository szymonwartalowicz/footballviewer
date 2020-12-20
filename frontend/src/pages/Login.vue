<template>
  <div>
    <form
      novalidate
      class="md-layout md-alignment-top-center"
      @submit.prevent="validateUser"
    >
      <md-card class="md-layout-item  md-size-50 md-small-size-100">
        <md-card-header>
          <div class="md-title">Login</div>
        </md-card-header>

        <md-card-content>
          <div class="md-layout md-gutter">
            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('login')">
                <label for="login">Login</label>
                <md-input
                  name="login"
                  id="login"
                  autocomplete="given-name"
                  v-model="form.login"
                  :disabled="sending"
                />
                <span class="md-error" v-if="!$v.form.login.required"
                  >The last name is required</span
                >
                <span class="md-error" v-else-if="!$v.form.login.minlength"
                  >Invalid last name</span
                >
              </md-field>
            </div>

            <div class="md-layout-item md-small-size-100">
              <md-field :class="getValidationClass('password')">
                <label for="password">Password</label>
                <md-input
                  type="password"
                  name="password"
                  id="password"
                  autocomplete="password"
                  v-model="form.password"
                  :disabled="sending"
                />
                <span class="md-error" v-if="!$v.form.password.required"
                  >The last name is required</span
                >
                <span class="md-error" v-else-if="!$v.form.password.minlength"
                  >Invalid last name</span
                >
              </md-field>
            </div>
          </div>
        </md-card-content>

        <md-progress-bar md-mode="indeterminate" v-if="sending" />

        <md-card-actions>
          <md-button
            type="submit"
            class="md-primary"
            v-on:click="login()"
            :disabled="sending"
            >Login</md-button
          >
        </md-card-actions>
      </md-card>

      <md-snackbar :md-active.sync="showSnack">{{ message }}</md-snackbar>
    </form>
  </div>
</template>

<script>
import { required, minLength } from "vuelidate/lib/validators";

export default {
  name: "FormValidation",
  data: () => ({
    form: {
      login: null,

      password: null
    },
    userSaved: null,
    sending: false,
    lastUser: null,
    message: null,
    showSnack: false
  }),
  validations: {
    form: {
      login: {
        required,
        minLength: minLength(3)
      },
      password: {
        required,
        minLength: minLength(3)
      }
    }
  },
  methods: {
    async login() {
      let credentials = {
        login: this.form.login,
        password: this.form.password
      };
      let response = await this.$fetch('', {
        method: "POST",
        body: JSON.stringify(credentials)
      });
      this.saveUser(response);

    },
    getValidationClass(fieldName) {
      const field = this.$v.form[fieldName];

      if (field) {
        return {
          "md-invalid": field.$invalid && field.$dirty
        };
      }
    },
    clearForm() {
      this.$v.$reset();
      this.form.login = null;
      this.form.password = null;
    },
    saveUser(admin) {
      this.sending = true;

      // Instead of this timeout, here you can call your API
      this.$store.commit("adminOn", admin);
      if (admin) {
        this.lastUser = `${this.form.login}`;
        this.message = "The user " + this.lastUser + "was saved with success!";
        this.sending = false;
        this.clearForm();
        this.$router.push({ name: "Players" });
        this.showSnack = true;
      } else {
        this.message = "Admin credentials incorrect";
        this.showSnack = true;
        this.sending = false;
        this.clearForm();
      }
      this.showSnack = false;
    },
    validateUser() {
      this.$v.$touch();

      if (!this.$v.$invalid) {
        this.saveUser();
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.md-progress-bar {
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
}
</style>
