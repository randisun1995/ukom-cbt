<template>
    <Head>
        <title>Edit Ujian - Aplikasi CBT Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link href="/admin/exams" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-edit"></i> Edit Ujian</h5>
                        <hr>
                        <form @submit.prevent="submit">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Nama Ujian</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Nama Ujian" v-model="form.title">
                                        <div v-if="errors.title" class="alert alert-danger mt-2">
                                        {{ errors.title }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Jabatan Dituju</label>
                                        <select class="form-select" v-model="form.position_id">
                                            <option v-for="(position, index) in positions" :key="index" :value="position.id">{{ position.title }}</option>
                                        </select>
                                        <div v-if="errors.position_id" class="alert alert-danger mt-2">
                                            {{ errors.position_id }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Deskripsi</label>
                                        <Editor
                                            api-key="no-api-key"
                                            v-model="form.description"
                                            :init="{
                                                menubar: false,
                                                plugins: 'lists link image emoticons',
                                                toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image emoticons'
                                            }"
                                        />
                                        <div v-if="errors.description" class="alert alert-danger mt-2">
                                            {{ errors.description }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Type</label>
                                        <select class="form-select" v-model="form.type">
                                            <option value="PG">Pilihan Ganda</option>
                                            <option value="Teks">Teks</option>
                                        </select>
                                        <div v-if="errors.type" class="alert alert-danger mt-2">
                                            {{ errors.type }}
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Acak Soal</label>
                                        <select class="form-select" v-model="form.random_question">
                                            <option value="Y">Y</option>
                                            <option value="N">N</option>
                                        </select>
                                        <div v-if="errors.random_question" class="alert alert-danger mt-2">
                                            {{ errors.random_question }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Acak Jawaban</label>
                                        <select class="form-select" v-model="form.random_answer">
                                            <option value="Y">Y</option>
                                            <option value="N">N</option>
                                        </select>
                                        <div v-if="errors.random_answer" class="alert alert-danger mt-2">
                                            {{ errors.random_answer }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Tampilkan Hasil</label>
                                        <select class="form-select" v-model="form.show_answer">
                                            <option value="Y">Y</option>
                                            <option value="N">N</option>
                                        </select>
                                        <div v-if="errors.show_answer" class="alert alert-danger mt-2">
                                            {{ errors.show_answer }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Durasi (Menit)</label>
                                        <input type="number" min="1" class="form-control" placeholder="Masukkan Durasi Ujian (Menit)" v-model="form.duration">
                                        <div v-if="errors.duration" class="alert alert-danger mt-2">
                                            {{ errors.duration }}
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

    //import tinyMCE
    import Editor from '@tinymce/tinymce-vue';

    export default {

        //layout
        layout: LayoutAdmin,

        //register components
        components: {
            Head,
            Link,
            Editor
        },

        //props
        props: {
            errors: Object,
            exam: Object,
            // levels: Array,
            positions: Array,
        },

        //inisialisasi composition API
        setup(props) {

            //define form with reactive
            const form = reactive({
                title: props.exam.title,
                // level_id: props.exam.level_id,
                position_id: props.exam.position_id,
                duration: props.exam.duration,
                description: props.exam.description,
                type: props.exam.type,
                random_question: props.exam.random_question,
                random_answer: props.exam.random_answer,
                show_answer: props.exam.show_answer,
            });

            //method "submit"
            const submit = () => {

                //send data to server
                Inertia.put(`/admin/exams/${props.exam.id}`, {
                    //data
                    title: form.title,
                    // level_id: form.level_id,
                    position_id: form.position_id,
                    duration: form.duration,
                    description: form.description,
                    type: form.type,
                    random_question: form.random_question,
                    random_answer: form.random_answer,
                    show_answer: form.show_answer,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Ujian Berhasil Diupdate!.',
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
