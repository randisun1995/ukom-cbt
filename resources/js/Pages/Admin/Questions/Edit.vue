<template>
    <Head>
        <title>Edit Soal Ujian - Aplikasi CBT Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link :href="`/admin/exams/${exam.id}`" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-question-circle"></i> Edit Soal Ujian</h5>
                        <hr>
                        <form @submit.prevent="submit">

                                    <div class="row">
                                        <div class="col-md-1">
                                            <label for="soal">Soal</label>
                                        </div>
                                        <div class="col-md-11">
                                            <div class="mb-4">
                                                <Editor
                                                    api-key="no-api-key"
                                                    v-model="form.question"
                                                    :init="{
                                                        menubar: false,
                                                        plugins: 'lists link image emoticons',
                                                        toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image emoticons'
                                                    }"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="exam.type !== 'Teks'">
                                                <div class="row">
                                                    <div class="col-md-1">
                                                        <label for="">Pilihan A</label>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="mb-4">
                                                            <Editor
                                                                api-key="no-api-key"
                                                                v-model="form.option_1"
                                                                :init="{
                                                                    height: 150,
                                                                    menubar: false,
                                                                    plugins: 'lists link image emoticons',
                                                                    toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image emoticons'
                                                                }"
                                                            />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1">
                                                        <label for="">Pilihan B</label>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="mb-4">
                                                                <Editor
                                                                    api-key="no-api-key"
                                                                    v-model="form.option_2"
                                                                    :init="{
                                                                        height: 150,
                                                                        menubar: false,
                                                                        plugins: 'lists link image emoticons',
                                                                        toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image emoticons'
                                                                    }"
                                                                />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-1">
                                                        <label for="">Pilihan C</label>
                                                    </div>
                                                        <div class="col-md-5">
                                                            <div class="mb-4">
                                                                <Editor
                                                                    api-key="no-api-key"
                                                                    v-model="form.option_3"
                                                                    :init="{
                                                                        height: 150,
                                                                        menubar: false,
                                                                        plugins: 'lists link image emoticons',
                                                                        toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image emoticons'
                                                                    }"
                                                                />
                                                            </div>
                                                        </div>

                                                    <div class="col-md-1">
                                                        <label for="">Pilihan D</label>
                                                    </div>
                                                        <div class="col-md-5">
                                                            <div class="mb-4">
                                                                <Editor
                                                                    api-key="no-api-key"
                                                                    v-model="form.option_4"
                                                                    :init="{
                                                                        height: 150,
                                                                        menubar: false,
                                                                        plugins: 'lists link image emoticons',
                                                                        toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image emoticons'
                                                                    }"
                                                                />
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-1">
                                                        <label for="">Pilihan E</label>
                                                    </div>
                                                        <div class="col-md-5">
                                                            <div class="mb-4">
                                                                <Editor
                                                                    api-key="no-api-key"
                                                                    v-model="form.option_5"
                                                                    :init="{
                                                                        height: 150,
                                                                        menubar: false,
                                                                        plugins: 'lists link image emoticons',
                                                                        toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image emoticons'
                                                                    }"
                                                                />
                                                            </div>
                                                        </div>
                                                            <div class="col-md-1">
                                                                <label for="" class="mb-2">Tipe</label>
                                                                    <p></p>
                                                                <label for="" class="mb-2">Level</label>
                                                                <p></p>
                                                                <label for="" class="mb-2">Kesulitan</label>
                                                            </div>

                                                            <div class="col-md-5">
                                                                <div class="mb-2">
                                                                    <select class="form-control" v-model="form.type">
                                                                        <option value="" disabled selected>Pilih salah satu opsi</option>
                                                                                <option value="PG">Pilihan Ganda</option>
                                                                                <option value="Teks">Text</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <select class="form-control" v-model="form.level">
                                                                    <option value="" disabled selected>Pilih salah satu opsi</option>
                                                                            <option value="1">Analis SDM Pertama</option>
                                                                            <option value="2">Analis SDM Muda</option>
                                                                            <option value="3">Analis SDM Madya</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-4">
                                                                    <select class="form-control" v-model="form.difficulty">
                                                                        <option value="" disabled selected>Pilih salah satu opsi</option>
                                                                            <option value="Mudah">Mudah</option>
                                                                            <option value="Sedang">Sedang</option>
                                                                            <option value="Sulit">Sulit</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                    </div>
                                        <div class="row">
                                            <div class="col-md-1">
                                            <label for="" class="mb-4">Jawaban</label>
                                            </div>
                                                <select class="form-control" v-model="form.answer">
                                                    <option value="1">A</option>
                                                    <option value="2">B</option>
                                                    <option value="3">C</option>
                                                    <option value="4">D</option>
                                                    <option value="5">E</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div v-if="exam.type == 'Teks'">
                                             <div class="row">
                                                <div class="col-md-1">
                                                <label for="" class="mb-4">Jawaban</label>
                                                </div>

                                                <div class="col-md-11">
                                                    <div class="mb-4">
                                                        <input type="text" class="form-control" v-model="form.answer">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            <button type="submit" class="btn btn-md btn-primary border-0 shadow me-2 mt-4">Simpan</button>
                            <button type="reset" class="btn btn-md btn-warning border-0 shadow mt-4">Reset</button>
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
            Editor,
        },

        //props
        props: {
            errors: Object,
            exam: Object,
            question: Object,
        },

        //inisialisasi composition API
        setup(props) {

            //define form with reactive
            const form = reactive({
                question: props.question.question,
                option_1: props.question.option_1,
                option_2: props.question.option_2,
                option_3: props.question.option_3,
                option_4: props.question.option_4,
                option_5: props.question.option_5,
                answer: props.question.answer,
                level: props.question.level,
                type: props.question.type,
                difficulty: props.question.difficulty,
            });

            //method "submit"
            const submit = () => {

                //send data to server
                Inertia.put(`/admin/exams/${props.exam.id}/questions/${props.question.id}/update`, {
                    //data
                    question: form.question,
                    option_1: form.option_1,
                    option_2: form.option_2,
                    option_3: form.option_3,
                    option_4: form.option_4,
                    option_5: form.option_5,
                    answer: form.answer,
                    level: form.level,
                    type: form.type,
                    difficulty: form.difficulty,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Soal Ujian Berhasil Dipdate!.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                });

            }

            //return
            return {
                form,
                submit,
            }

        }

    }

</script>

<style>

</style>
