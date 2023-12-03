<template>
    <Head>
        <title>Peserta Wawancara - Uji Kompetensi JFK</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row mt-1">
            <div class="col-md-12">
                <Link href="/examiners/interviews" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <div class="row">
                                <div class="col-md-2">
                                        <label>NIP</label>
                                </div>
                                <div class="col-md-4">
                                        <label for="NIP">: {{ participant.participant.nip }}</label>
                                </div>
                                <div class="col-md-2">
                                        <label>ID Participant</label>
                                </div>
                                <div class="col-md-2">
                                        <label for="NIP">: {{ participant.participant.id }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                        <label>Nama</label>
                                </div>
                                <div class="col-md-4">
                                        <label for="NIP">: {{ participant.participant.name }}</label>
                                </div>
                                <div class="col-md-2">
                                        <label>ID Examgroup</label>
                                </div>
                                <div class="col-md-2">
                                        <label for="NIP">: {{ participant.id }}</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                        <label>Jabatan Tujuan</label>
                                </div>
                                <div class="col-md-4">
                                        <label for="NIP" >: {{ participant.participant.position.title }} {{ participant.participant.position.level.title }}</label>
                                </div>
                                <!-- <div class="col-md-2">
                                        <label>Nama</label>
                                </div>
                                <div class="col-md-2">
                                        <label for="NIP">: {{ participant.participant.name }}</label>
                                </div> -->
                            </div>
                            <hr>
                            <label for="">Form Penilaian Wawancara</label>
                            <hr>

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
                                        <template v-for="(indicator, index) in indicators.data" :key="index">
                                            <!-- Menampilkan grup hanya jika 'sub' atau 'subsub' berbeda dari sebelumnya -->
                                            <template v-if="index === 0 || indicator.sub !== indicators.data[index - 1].sub || indicator.subsub !== indicators.data[index - 1].subsub">
                                                <tr>
                                                <td colspan="6">{{ indicator.sub }} - {{ indicator.subsub }}</td>
                                                </tr>
                                            </template>
                                            <tr>
                                                <td class="fw-bold text-center">
                                                {{ ++index + (indicators.current_page - 1) * indicators.per_page }}
                                                </td>
                                                <td>{{ indicator.title }}{{ indicator.id }}</td>
                                                <input type="text" class="form-control" :placeholder="'Masukkan Nilai untuk ' + indicator.id" v-model="scores[indicator.id]">
                                            </tr>
                                        </template>
                                                <!-- <input type="text" class="form-control" :placeholder="Total" :velue=""> -->
                                    </tbody>
                                </table>
                                <button type="submit" class="btn btn-md btn-primary border-0 shadow me-2 mt-4">Simpan</button>
                            </div>

                        </form>

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
        Link,

    } from '@inertiajs/inertia-vue3';


    //import reactive from vue
    import { reactive } from 'vue';

    //import inerita adapter
    import { Inertia } from '@inertiajs/inertia';

    //import sweet alert2
    import Swal from 'sweetalert2';

    export default {

        //layout
        layout: LayoutExaminer,

        //register components
        components: {
            Head,
            Link
        },

        //props
        props: {
            errors: Object,
            participant: Object,
            indicators: Object
        },

        //inisialisasi composition API
        setup(props) {

            //define state form with reactive
            const scores = reactive({
                examiner_group_id: props.participant.id,
                participant_id: props.participant.participant.id,
                indicator_id: props.indicators.id,
                score:'',
            });

            //method "submit"
            const submit = () => {

                            // Mengumpulkan semua skor dari objek "scores"
            const scoresArray = [];
            for (const indicatorId in scores) {
                if (scores.hasOwnProperty(indicatorId) && indicatorId !== 'examiner_group_id' && indicatorId !== 'participant_id' && indicatorId !== 'indicator_id' && indicatorId !== 'score' && scores[indicatorId] !== null) {
                    scoresArray.push({
                        examiner_group_id: scores.examiner_group_id,
                        participant_id: scores.participant_id,
                        indicator_id: indicatorId,
                        score: scores[indicatorId],
                    });
                }
            }
                //send data to server
                Inertia.post('/examiners/interviews', {
                    //data
                    examiner_group_id: scores.examiner_group_id,
                    participant_id: scores.participant_id,
                    indicator_id: scores.indicator_id,
                    scores: scoresArray, // Mengirim array skor ke server
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Jenjang Berhasil Disimpan!.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                });
            }

            //return
            return {
                scores,
                submit,
            }

        }

    }

</script>

<style>

</style>
