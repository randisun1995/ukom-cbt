<template>
    <Head>
        <title>Edit Jabatan - Aplikasi CBT Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link href="/admin/positions" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-clone"></i> Edit Jabatan</h5>
                        <hr>
                        <form @submit.prevent="submit">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Nama Jabatan</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Nama Jabatan" v-model="form.title">
                                        <div v-if="errors.title" class="alert alert-danger mt-2">
                                            {{ errors.title }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Jenjang</label>
                                        <select class="form-select" v-model="form.level_id">
                                            <option v-for="(level, index) in levels" :key="index" :value="level.id">{{ level.title }}</option>
                                        </select>
                                        <div v-if="errors.level_id" class="alert alert-danger mt-2">
                                            {{ errors.level_id }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-md btn-primary border-0 shadow me-2">Update</button>
                            <button type="reset" class="btn btn-md btn-warning border-0 shadow">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    //import layout
    import LayoutAdmin from '../../../Layouts/Admin.vue';

    //import Heade and Link from Inertia
    import {
        Head,
        Link
    } from '@inertiajs/inertia-vue3';

    //import reactive from vue
    import { reactive } from 'vue';

    //import inerita adapter
    import { Inertia } from '@inertiajs/inertia';

    //import sweet alert2
    import Swal from 'sweetalert2';

    export default {

        //layout
        layout: LayoutAdmin,

        //register components
        components: {
            Head,
            Link
        },

        //props
        props: {
            errors: Object,
            position: Object,
            levels: Array,
        },

        //inisialisasi composition API
        setup(props) {

            //define form with reactive
            const form = reactive({
                title: props.position.title,
                level_id: props.position.level_id,
            
            });

            //method "submit"
            const submit = () => {

                //send data to server
                Inertia.put(`/admin/positions/${props.position.id}`, {
                    //data
                    title: form.title,
                    level_id: form.level_id,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Jabatan Berhasil Diupdate!.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                });

            }

            return {
                form,
                submit,
            }

        }

    }

</script>

<style>

</style>
