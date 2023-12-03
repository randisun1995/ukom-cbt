<template>
    <Head>
        <title>Enrolle Peserta - Aplikasi Uji Kompetensi Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link :href="`/admin/examiners/${examiner.id}`" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i
                    class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-user-plus"></i> Enrolle Peserta </h5>  <input type="text" class="form-control"  v-model="form.examsession_id">
                        <hr>
                        <form @submit.prevent="submit">

                            <div class="table-responsive mb-4">
                                <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                    <thead class="thead-dark">
                                        <tr class="border-0">
                                            <th class="border-0 rounded-start" style="width:5%">
                                                <input type="checkbox" v-model="form.allSelected" @change="selectAll" />
                                            </th>
                                            <th class="border-0">Nama Peserta</th>
                                            <th class="border-0">Jabatan</th>
                                            <th class="border-0">Jenis Ujikom</th>
                                        </tr>
                                    </thead>
                                    <div class="mt-3"></div>
                                    <tbody>
                                        <tr v-for="participant of participants" :key="participant.id">
                                            <td>
                                                <input type="checkbox" v-model="form.participant_id" :id="participant.id" :value="participant.participant.id" number :checked="form.allSelected" />
                                            </td>
                                            <td>{{ participant.participant.name }}</td>
                                            <td class="text-center">{{ participant.participant.position.title }}</td>
                                            <td class="text-center">{{ participant.participant.id }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-if="errors.participant_id" class="alert alert-danger mt-2">
                                    {{ errors.participant_id }}
                                </div>
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
    import {
      computed,
        reactive
    } from 'vue';

    //import inerita adapter
    import {
        Inertia
    } from '@inertiajs/inertia';

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
            participants: Array,
            examsession_id: Object,
        },

        //inisialisasi composition API
        setup(props) {

            //define form with reactive
            const form = reactive({
                examiner: props.examiner.id,
                examsession_id: props.examsession_id,
                participant_id: [],
                allSelected: false,
            });

            //define method "selectAll"
            const selectAll = () => {
                if (form.allSelected) {
                    form.participant_id = props.participants.map(participant => participant.id);
                } else {
                    form.participant_id = [];
                }
            }

            //method "submit"
            const submit = () => {

                //send data to server
                Inertia.post(`/admin/examiners/${props.examiner.id}/enrolle/store`, {
                    //data
                    examiner: form.examiner.id,
                    examsession_id: form.examsession_id,
                    participant_id: form.participant_id,
                }, {
                    onSuccess: () => {
                        // show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Enrolle Peserta Berhasil Disimpan!.',
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
                selectAll,
                submit,
            };

        }

    }

</script>

<style>

</style>
