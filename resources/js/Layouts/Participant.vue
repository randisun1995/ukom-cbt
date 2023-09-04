<template>
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-dark navbar-theme-primary bg-dark mb-4 shadow">
        <div class="container position-relative">
            <Link class="navbar-brand" href="/participant/dashboard">
                <img class="navbar-brand-dark" src="/assets/images/logo-pusbin.png" style="height:100px">
            </Link>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                </ul>
                <form class="d-flex" v-if="$page.props.auth.participant">
                    <Link href="/logout" method="POST" class="btn btn-secondary shadow" as="button">LOGOUT</Link>
                </form>
            </div>
        </div>
    </nav>
    <div class="container">
        <slot />
    </div>
</template>

<script>

    //import Link
    import { Link } from '@inertiajs/inertia-vue3';

    export default {

        //register components
        components: {
            Link
        },

    }

</script>

<style>

</style>
