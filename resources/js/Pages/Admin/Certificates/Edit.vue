<template>
    <Head>
        <title>Edit Sertifikat - Aplikasi CBT Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link href="/admin/cetificates" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-clone"></i> Edit Sertifikat</h5>
                        <hr>
                        <form @submit.prevent="submit">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>NIP</label>
                                        <input type="text" class="form-control" placeholder="Masukkan NIP Peserta" v-model="form.nip">
                                        <div v-if="errors.nip" class="alert alert-danger mt-2">
                                            {{ errors.nip }}
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label>Uji Kompetensi</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Uji Kompetensi" v-model="form.title">
                                        <div v-if="errors.title" class="alert alert-danger mt-2">
                                            {{ errors.title }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Link Sertifikat</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Link Sertifikat" v-model="form.link">
                                        <div v-if="errors.link" class="alert alert-danger mt-2">
                                            {{ errors.link }}
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
            certificate: Object,

        },

        //inisialisasi composition API
        setup(props) {

            //define form with reactive
            const form = reactive({
                nip: props.certificate.nip,
                title: props.certificate.title,
                link: props.certificate.link,

            });

            //method "submit"
            const submit = () => {

                //send data to server
                Inertia.put(`/admin/certificates/${props.certificate.id}`, {
                    //data\
                    nip: form.nip,
                    title: form.title,
                    link: form.link,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Sertifikat Berhasil Diupdate!.',
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
