<template>
    <Head>
        <title>Edit Tim Penilai - Aplikasi Uji Kompetensi Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link href="/admin/examiners" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-user"></i> Edit Tim Penilai</h5>
                        <hr>
                        <form @submit.prevent="submit">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>NIP</label>
                                        <input type="text" class="form-control" placeholder="Masukkan NIP Tim Penilai" v-model="form.nip">
                                        <div v-if="errors.nisn" class="alert alert-danger mt-2">
                                            {{ errors.nip }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Nama Lengkap</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Nama Tim Penilai" v-model="form.name">
                                        <div v-if="errors.name" class="alert alert-danger mt-2">
                                            {{ errors.name }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Role</label>
                                        <select class="form-select" v-model="form.role">
                                            <option value="" disabled selected>Pilih Role</option>
                                            <option value="Penguji">Penguji</option>
                                            <option value="Sekre">Sekre</option>
                                        </select>
                                        <div v-if="errors.role" class="alert alert-danger mt-2">
                                            {{ errors.role }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Sesi Ujian</label>
                                        <select class="form-select" v-model="form.examsession_id" >
                                            <option v-for="(examsession, index) in examsessions" :key="index" :value="examsession.id" >{{ examsession.title }} {{ examsession.exam.position.title }} {{ examsession.exam.position.level.title }}</option>
                                        </select>
                                        <div v-if="errors.examsession_id" class="alert alert-danger mt-2">
                                            {{ errors.examsession_id }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                 <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Password</label>
                                        <input type="password" class="form-control" placeholder="Masukkan Password" v-model="form.password">
                                        <div v-if="errors.password" class="alert alert-danger mt-2">
                                            {{ errors.password }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Konfirmasi Password</label>
                                        <input type="password" class="form-control" placeholder="Masukkan Konfirmasi Password" v-model="form.password_confirmation">
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
            examiner: Object,
            examsessions: Array,
        },
        computed: {
        filteredExamsessions() {
        return this.examsessions.filter(examsession => examsession.exam.position.level.title === 'Umum');
            }
        },



        //inisialisasi composition API
        setup(props) {

            //define form with reactive
            const form = reactive({
                nip: props.examiner.nip,
                name: props.examiner.name,
                role: props.examiner.role,
                examsession_id: props.examiner.examsession_id,
                password: '',
                password_confirmation: ''
            });

            //method "submit"
            const submit = () => {

                //send data to server
                Inertia.put(`/admin/examiners/${props.examiner.id}`, {
                    //data
                    nip: form.nip,
                    name: form.name,
                    role: form.role,
                    examsession_id: form.examsession_id,
                    password: form.password,
                    password_confirmation: form.password_confirmation
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Tim Penilai Berhasil Diupdate!.',
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
            };

        }

    }

</script>

<style>

</style>
