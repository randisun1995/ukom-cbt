<template>
    <Head>
        <title>Jadwalkan Peserta - Aplikasi Uji Kompetensi Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">

                <Link href="/admin/examiners" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>

                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <h5> <i class="fa fa-edit"></i> Detail Penguji</h5>
                        <hr>
                        <div class="table-responsive">

                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <tbody>
                                    <tr>
                                        <td style="width:30%" class="fw-bold">Nama</td>
                                        <td>{{ examiner.name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Sebagai</td>
                                        <td>{{ examiner.role }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Grup Ujian</td>
                                        <td>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5> <i class="fa fa-user-plus"></i> Enrolled Peserta</h5>
                        <hr>

                        <Link :href="`/admin/examiners/${examiner.id}/enrolle/create`" class="btn btn-md btn-primary border-0 shadow me-2" type="button"><i class="fa fa-user-plus"></i> Enrolle Peserta</Link>

                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark">
                                    <tr class="border-0">
                                        <th class="border-0 rounded-start" style="width:5%">No.</th>
                                        <th class="border-0">Nama Peserta</th>
                                        <th class="border-0">Jabatan</th>
                                        <th class="border-0 rounded-end" style="width:15%">Aksi</th>
                                    </tr>
                                </thead>
                                <div class="mt-2"></div>
                                <tbody>
                                    <tr v-for="(data, index) in examiner.examiner_groups.data" :key="index">
                                        <td class="fw-bold text-center">{{ ++index + (examiner.examiner_groups.current_page - 1) * examiner.examiner_groups.per_page }}</td>
                                        <td>{{ data.participant.name }}</td>
                                        <td class="text-center">{{ data.participant.position.title }}</td>
                                        <td class="text-center">
                                            <button @click.prevent="destroy(examiner.id, data.id)" class="btn btn-sm btn-danger border-0"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :links="examiner.examiner_groups.links" align="end" />
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

     //import reactive from vue
     import { reactive } from 'vue';

    //import inertia adapter
    import { Inertia } from '@inertiajs/inertia';

    //import sweet alert2
    import Swal from 'sweetalert2';

    export default {

        //layout
        layout: LayoutAdmin,

        //register components
        components: {
            Head,
            Link,
            Pagination
        },

        //props
        props: {
            errors: Object,
            examiner: Object,
            examsessions: Array,
        },
//inisialisasi composition API
setup() {
//define form with reactive
const form = reactive({
    examsession_id: '',
            });
//method "submit"
const submit = () => {

//send data to server
Inertia.post('/admin/examiners/$props.aprraiser.id/method/store', {
    //data
    examsession_id: form.examsession_id,
}, {
    onSuccess: () => {
        //show success alert
        Swal.fire({
            title: 'Success!',
            text: 'Exam Session Berhasil Disimpan.',
            icon: 'success',
            showConfirmButton: false,
            timer: 2000
        });
    },
});

}
//define method destroy
const destroy = (examiner_id, examiner_group_id) => {
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

            Inertia.delete(`/admin/examiners/${examiner_id}/enrolle/${examiner_group_id}/destroy`);

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
    form,
    destroy,
    submit,
}

}

}

</script>

<style>

</style>
