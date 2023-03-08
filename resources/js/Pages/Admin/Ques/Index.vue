<template>
    <Head>
        <title>Bank Soal - Aplikasi CBT Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-2 col-12 mb-2">
                        <Link href="/admin/questions/create" class="btn btn-md btn-primary border-0 shadow w-100" type="button"><i
                            class="fa fa-plus-circle"></i>
                        Tambah</Link>
                    </div>
                    <div class="col-md-2 col-12 mb-2">
                        <Link href="/admin/questions/import" class="btn btn-md btn-success border-0 shadow w-100 text-white" type="button"><i
                            class="fa fa-file-excel"></i>
                        Import</Link>
                    </div>
                    <div class="col-md-8 col-12 mb-2 ms-0">
                        <form @submit.prevent="handleSearch">
                            <div class="input-group">
                                <input type="text" class="form-control border-0 shadow" v-model="search" placeholder="masukkan kata kunci dan enter...">
                                <span class="input-group-text border-0 shadow">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark">
                                    <tr class="border-0">
                                        <th class="border-0 rounded-start" style="width:5%">No.</th>
                                        <th class="border-0" style="width:80%">Soal</th>
                                        <th class="border-0 rounded-end" style="width:15%">Aksi</th>
                                    </tr>
                                </thead>
                                <div class="mt-2"></div>
                                <tbody>
                                    <tr v-for="(ques, index) in quess.data" :key="index">
                                        <td class="fw-bold text-center">{{ ++index + (quess.current_page - 1) * quess.per_page }}</td>
                                        <td>
                                            <div style="word-wrap: break-word; white-space: normal;" class="fw-bold" v-html="ques.question"></div>
                                            <div class="mt-2" v-html="ques.exam.title"></div>
                                            <hr>
                                            <ol type="A">
                                                <li v-html="ques.option_1" :class="{ 'text-success fw-bold': ques.answer == '1' }"></li>
                                                <li v-html="ques.option_2" :class="{ 'text-success fw-bold': ques.answer == '2' }"></li>
                                                <li v-html="ques.option_3" :class="{ 'text-success fw-bold': ques.answer == '3' }"></li>
                                                <li v-html="ques.option_4" :class="{ 'text-success fw-bold': ques.answer == '4' }"></li>
                                                <li v-html="ques.option_5" :class="{ 'text-success fw-bold': ques.answer == '5' }"></li>
                                            </ol>
                                        </td>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <Link :href="`/admin/questions/${ques.id}/edit`" class="btn btn-sm btn-info border-0 shadow me-2" type="button"><i class="fa fa-pencil-alt"></i></Link>
                                            <button @click.prevent="destroy(ques.id)" class="btn btn-sm btn-danger border-0"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :links="quess.links" align="end" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    //import layout
    import LayoutAdmin from '../../../Layouts/Admin.vue';

    //import component pagination
    import Pagination from '../../../Components/Pagination.vue';

    //import Heade and Link from Inertia
    import {
        Head,
        Link
    } from '@inertiajs/inertia-vue3';

    //import ref from vue
    import {
        ref
    } from 'vue';

    //import inertia adapter
    import { Inertia } from '@inertiajs/inertia';

    //import sweet alert2
    import Swal from 'sweetalert2';

    export default {
        //layout
        layout: LayoutAdmin,

        //register component
        components: {
            Head,
            Link,
            Pagination
        },

        //props
        props: {
            quess: Object,
            exams: Object,
        },

        //inisialisasi composition API
        setup() {

            //define state search
            const search = ref('' || (new URL(document.location)).searchParams.get('q'));

            //define method search
            const handleSearch = () => {
                Inertia.get('/admin/questions', {

                    //send params "q" with value from state "search"
                    q: search.value,
                });
            }

            //define method destroy
            const destroy = (id) => {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak akan dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                })
                .then((result) => {
                    if (result.isConfirmed) {

                        Inertia.delete(`/admin/questions/${id}`);

                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Pertanyaan Berhasil Dihapus!.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                    }
                })
            }

            //return
            return {
                search,
                handleSearch,
                destroy,
            }

        }
    }

</script>

<style>

</style>
