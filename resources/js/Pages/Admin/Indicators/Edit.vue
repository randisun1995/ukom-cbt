<template>
    <Head>
        <title>Edit Indikator Penilaian - Aplikasi Uji Kompetensi Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link href="/admin/appraisers" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-user"></i> Edit Indikator Penilaian</h5>
                        <hr>
                        <form @submit.prevent="submit">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Title</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Nama Indikator" v-model="form.title">
                                        <div v-if="errors.title" class="alert alert-danger mt-2">
                                            {{ errors.title }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Kategori</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Kategori Indikator" v-model="form.cathegory">
                                        <div v-if="errors.cathegory" class="alert alert-danger mt-2">
                                            {{ errors.cathegory }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Sub</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Sub Indikator" v-model="form.sub">
                                        <div v-if="errors.sub" class="alert alert-danger mt-2">
                                            {{ errors.sub }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Sub-sub</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Sub-sub Indikator" v-model="form.subsub">
                                        <div v-if="errors.subsub" class="alert alert-danger mt-2">
                                            {{ errors.subsub }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Status</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Status Indikator" v-model="form.status">
                                        <div v-if="errors.status" class="alert alert-danger mt-2">
                                            {{ errors.status }}
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Konfirmasi Password</label>
                                        <input type="password" class="form-control" placeholder="Masukkan Konfirmasi Password" v-model="form.password_confirmation">
                                    </div>
                                </div> -->
                            </div>
                            <button type="submit" class="btn btn-md btn-primary border-0 shadow me-2">Simpan</button>
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
            indicators: Object,

        },


        //inisialisasi composition API
        setup(props) {

            //define form with reactive
            const form = reactive({
                title: props.indicators.title,
                cathegory: props.indicators.cathegory,
                sub: props.indicators.sub,
                subsub: props.indicators.subsub,
                status: props.indicators.status,
            });

            //method "submit"
            const submit = () => {

                //send data to server
                Inertia.put(`/admin/indicators/${props.indicators.id}`, {
                    //data
                    title: form.title,
                    cathegory: form.cathegory,
                    sub: form.sub,
                    subsub: form.subsub,
                    status: form.status,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Indikator Penilaian Berhasil Diupdate!.',
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
