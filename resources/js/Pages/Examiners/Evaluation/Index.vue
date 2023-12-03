<template>
    <Head>
        <title>Penilaian Wawancara - Uji Kompetensi JFK</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-7 col-12 mb-2">
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
                                        <th class="border-0">Indikator</th>
                                        <th class="border-0">Nilai</th>
                                    </tr>
                                </thead>
                                <div class="mt-2"></div>
                                <tbody>
                                    <!-- <tr v-for="(examinergroup, index) in examinergroups.data" :key="index">
                                        <td class="fw-bold text-center">
                                            {{ ++index + (examinergroups.current_page - 1) * examinergroups.per_page }}</td>
                                        <td>{{ examinergroup.participant.nip }}</td>
                                        <td>{{ examinergroup.participant.name }}</td>
                                        <td class="">{{ examinergroup.participant.position.title }} {{ examinergroup.participant.position.level.title }}</td>
                                        <td>{{ examinergroup.participant.type }}</td>
                                        <td class="text-center">
                                            <Link :href="`/examiners/interviews/${examinergroup.id}/edit`" class="btn btn-sm btn-info border-0 shadow me-2" type="button"><i class="fa fa-pencil-alt"></i></Link>
                                        </td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                        <Pagination :links="examinergroups.links" align="end" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    //import layout
    import LayoutExaminer from '../../../Layouts/Examiner.vue';

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
    import {
        Inertia
    } from '@inertiajs/inertia';

    //import sweet alert2
    import Swal from 'sweetalert2';

    export default {
        //layout
        layout: LayoutExaminer,

        //register component
        components: {
            Head,
            Link,
            Pagination
        },

        //props
        props: {
            // examinergroups: Object,

        },

        //inisialisasi composition API
        setup() {

            //define state search
            const search = ref('' || (new URL(document.location)).searchParams.get('q'));

            //define method search
            // const handleSearch = () => {
            //     Inertia.get('/examiners/interviews', {

            //         //send params "q" with value from state "search"
            //         q: search.value,
            //     });
            // }

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

                            Inertia.delete(`/examiners/interviews/${id}`);

                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Peserta Berhasil Dihapus!.',
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
