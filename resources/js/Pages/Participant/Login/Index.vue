<template>
    <Head>
        <title>Login Peserta - Aplikasi CBT Online</title>
    </Head>
   
    <div class="row justify-content-center mt-6">
        <div class="col-md-5">
            <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                <h4 class="text-center mb-5">LOGIN PESERTA</h4>
                <div v-if="errors.message" class="alert alert-danger mt-2">
                    {{ errors.message }}
                </div>
                <div v-if="$page.props.session.error" class="alert alert-danger mt-2">
                    {{ $page.props.session.error }}
                </div>
                <form @submit.prevent="submit" class="mt-4">
                    <div class="form-group mb-4 ms-4">
                        <div class="input-group">
                            <div class="form-floating">
                            <input type="text" class="form-control" id="nip" autofocus v-model="form.nip" placeholder="NIP" size="30">
                            <label for="nip"> <i class="fa fa-key me-3"></i>NIP</label>
                            </div>
                        </div>
                        <div v-if="errors.nip" class="alert alert-danger mt-2">
                            {{ errors.nip }}
                        </div>
                    </div>
                        <div class="form-group mb-4 ms-4">
                            <div class="input-group">
                                <div class="form-floating">
                                <input type="password" placeholder="Password" id="password" class="form-control"
                                    v-model="form.password" size="30">
                                    <label for="password"><i class="fa fa-lock me-3"></i>Password</label>
                                </div>
                            </div>
                            <div v-if="errors.password" class="alert alert-danger mt-2">
                                {{ errors.password }}
                            </div>
                        </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-gray-800 py-3 w-50">LOGIN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</template>

<script>
    //import layout
    import LayoutParticipant from '../../../Layouts/Participant.vue';

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
        layout: LayoutParticipant,

        //register component
        components: {
            Head
        },

        //props
        props: {
            errors: Object,
        },

        //inisialisasi composition API
        setup() {

            //define form state
            const form = reactive({
                nip: '',
                password: '',
            });

            //submit method
            const submit = () => {

                //send data to server
                Inertia.post('/participants/login', {

                    //data
                    nip: form.nip,
                    password: form.password,
                });
            }

            //return
            return {
                form,
                submit
            }
        }

    }

</script>

<style>

</style>
