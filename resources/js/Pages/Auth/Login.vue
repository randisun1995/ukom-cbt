<template>

    <Head>
        <title>Login Administrator - CBT Online</title>
    </Head>
    <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
        <div class="text-center text-md-center mb-4 mt-md-0">
            <h3>ADMINISTRATOR</h3>
        </div>
        <form @submit.prevent="submit" class="mt-4">
            <div class="form-group mb-4">
                <div class="input-group">
                <div class="form-floating">
                    <input type="email" class="form-control" v-model="form.email" placeholder="Email Address" id="email"  size="40">
                    <label for="email"> <i class="fa fa-envelope me-3"></i>Email</label>
                </div>
                </div>
                <div v-if="errors.email" class="alert alert-danger mt-2">
                    {{ errors.email }}
                </div>
            </div>

            <div class="form-group">
                <div class="form-group mb-4">
                    <div class="input-group">
                        <div class="form-floating">
                        <input type="password" placeholder="Password" class="form-control" v-model="form.password" id="password" size="40">
                        <label for="password"><i class="fa fa-lock me-3"></i>Password</label>
                        </div>
                    </div>
                    <div v-if="errors.password" class="alert alert-danger mt-2">
                        {{ errors.password }}
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-top mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="remember">
                        <label class="form-check-label mb-0" for="remember">
                            Remember me
                        </label>
                    </div>
                </div>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-gray-800">LOGIN</button>
            </div>
        </form>
    </div>
</template>

<script>
    //import layout
    import LayoutAuth from '../../Layouts/Auth.vue';

    //import Head from Inertia
    import {
        Head
    } from '@inertiajs/inertia-vue3';

    //import reactive
    import {
        reactive
    } from 'vue';

    //import inertia adapter
    import {
        Inertia
    } from '@inertiajs/inertia';

    export default {

        //layout
        layout: LayoutAuth,

        //register component
        components: {
            Head
        },

        //props
        props: {
            errors: Object,
            session: Object
        },

        //define composition API
        setup() {

            //define form state
            const form = reactive({
                email: '',
                password: '',
            });

            //submit method
            const submit = () => {

                //send data to server
                Inertia.post('/login', {

                    //data
                    email: form.email,
                    password: form.password,
                });
            }

            //return form state and submit method
            return {
                form,
                submit,
            };

        }

    }

</script>
