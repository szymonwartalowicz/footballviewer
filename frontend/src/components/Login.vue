<template>
    <div>
        <h2>Login</h2>
        <form @submit.prevent="login">
            <label for="admin">Admin<label>
                <input type="email" name="admin" id="admin" v-model="admin">
            <br>
            <label for="password">password<label>
                <input type="password" name="password" id="password" v-model="password">
            <button type="submin">Login</button>
        </form
    </div>
</template>

<script>
export default {
    name: 'Login',
    data() {
        return {
            admin: '',
            password: ''
        }
    },
    methods: {
        login() {

        }
    }
}
</script>
