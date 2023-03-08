<template>
    <Head>
        <title>Konfirmasi Ujian - Aplikasi CBGT Online</title>
    </Head>
    <div class="row">
        <div class="col-md-12">
            <Link href="/participant/dashboard" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i
                class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h5> <i class="fa fa-file"></i> Deskripsi Ujian</h5>
                    <hr>
                    <div v-html="exam_group.exam.description"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <h5> <i class="fa fa-list-ul"></i> Detail Peserta</h5>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 rounded">
                            <thead>
                                <tr>
                                    <td class="fw-bold">NIP</td>
                                    <td>{{ exam_group.participant.nip }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Nama Lengkap</td>
                                    <td>{{ exam_group.participant.name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Jabatan</td>
                                    <td>{{ exam_group.participant.position.title }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold center-center">Jenjang</td>
                                    <td>{{ exam_group.exam.level.title }}</td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;" class="fw-bold">Jenis Ujian</td>
                                    <td style="word-wrap: break-word; white-space: normal;">{{ exam_group.exam_session.title }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Durasi</td>
                                    <td>{{ exam_group.exam.duration }} Menit</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div v-if="grade.end_time == null">
                        <Link :href="`/participant/exam-start/${exam_group.id}`"
                            class="btn btn-md btn-success border-0 shadow w-100 mt-2 text-white">Mulai</Link>
                    </div>
                    <div v-else>
                        <button class="btn btn-md btn-primary border-0 shadow w-100 mt-2" disabled>Sudah
                            Mengerjakan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    //import layout student
    import LayoutParticipant from '../../../Layouts/Participant.vue';

    //import Head and Link from Inertia
    import {
        Head,
        Link
    } from '@inertiajs/inertia-vue3';

    export default {
        //layout
        layout: LayoutParticipant,

        //register components
        components: {
            Head,
            Link
        },

        //props
        props: {
            exam_group: Object,
            grade: Object
        },
    }

</script>

<style>

</style>
