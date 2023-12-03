.<template>
    <Head>
        <title>Sertifikat Peserta - Aplikasi CBT Online</title>
    </Head>
    <div class="row mt-1">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark">
                                    <tr class="border-0">
                                        <th class="border-0 rounded-start" style="width:5%">No.</th>
                                        <th class="border-0">Uji Kompetensi</th>
                                        <th class="border-0">Link Sertifikat</th>
                                    </tr>
                                </thead>
                                <div class="mt-2"></div>
                                <tbody>

                                    <tr v-for="(certificate, index) in certificates.data" :key="index">
                                        <td class="fw-bold text-center">
                                            {{ ++index  }}</td>
                                        <td>{{ certificate.title }}</td>
                                        <td><a :href="certificate.link" :download="'sertifikat.pdf'" target="_blank"><u>Lihat Sertifikat</u> </a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>


</template>

<script>
    //import layout student
    import LayoutParticipant from '../../../Layouts/Participant.vue';

    //import Link from Inertia
    import {
        Link
    } from '@inertiajs/inertia-vue3';

    export default {

        //layout
        layout: LayoutParticipant,

        //register components
        components: {
            Link,
        },

        //register props
        props: {
            auth: Object,
            certificates: Object
        }

    }


</script>

<style>

</style>
