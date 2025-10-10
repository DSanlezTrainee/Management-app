<script setup>
import { ref } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import Banner from "@/Components/Banner.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(
        route("current-team.update"),
        {
            team_id: team.id,
        },
        {
            preserveState: false,
        },
    );
};

const logout = () => {
    router.post(route("logout"));
};
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div
            class="min-h-screen bg-gradient-to-br from-blue-50 via-blue-100 to-blue-300 dark:from-blue-900 dark:via-blue-800 dark:to-blue-700 text-gray-700 dark:text-gray-200 flex flex-items justify-center"
        >
            <!-- Navigation -->
            <nav
                class="w-full fixed top-0 left-0 z-30 bg-blue-900/90 dark:bg-blue-950/90 backdrop-blur-lg shadow-md border-b border-blue-800 flex items-center justify-between px-6 sm:px-12 py-4"
            >
                <!-- Logo + Title -->
                <div class="flex items-center gap-2">
                    <a href="/"
                        ><span
                            class="font-extrabold text-xl sm:text-2xl text-white tracking-tight select-none"
                            >Management App</span
                        ></a
                    >
                    <span
                        class="hidden sm:inline-block text-xs font-medium text-blue-200 dark:text-blue-300"
                        >Manage with simplicity</span
                    >
                </div>

                <div class="flex items-center gap-4">
                    <Dropdown align="left" width="48">
                        <template #trigger>
                            <button
                                type="button"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-full text-blue-900 bg-blue-100 hover:bg-blue-200 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-[#FF2D20] dark:text-blue-100 dark:bg-blue-800 dark:hover:bg-blue-700 dark:focus-visible:ring-white shadow-sm"
                            >
                                Entities
                                <svg
                                    class="ms-2 -me-0.5 size-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                                    />
                                </svg>
                            </button>
                        </template>
                        <template #content>
                            <div class="flex flex-col gap-1 min-w-[140px]">
                                <DropdownLink
                                    :href="route('entities.clients')"
                                    :active="
                                        route().current('entities.clients')
                                    "
                                >
                                    Clients
                                </DropdownLink>
                                <DropdownLink
                                    :href="route('entities.suppliers')"
                                    :active="
                                        route().current('entities.suppliers')
                                    "
                                >
                                    Suppliers
                                </DropdownLink>
                            </div>
                        </template>
                    </Dropdown>
                    <NavLink
                        :href="route('contacts.index')"
                        :active="route().current('contacts.index')"
                    >
                        Contacts
                    </NavLink>
                    <Dropdown align="left" width="48">
                        <template #trigger>
                            <button
                                type="button"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-full text-blue-900 bg-blue-100 hover:bg-blue-200 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-[#FF2D20] dark:text-blue-100 dark:bg-blue-800 dark:hover:bg-blue-700 dark:focus-visible:ring-white shadow-sm"
                            >
                                Configurations
                                <svg
                                    class="ms-2 -me-0.5 size-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                                    />
                                </svg>
                            </button>
                        </template>
                        <template #content>
                            <div class="flex flex-col gap-1 min-w-[140px]">
                                <DropdownLink
                                    :href="route('vat-rates.index')"
                                    :active="route().current('vat-rates.index')"
                                >
                                    Entities: Countries
                                </DropdownLink>
                                <DropdownLink
                                    :href="route('vat-rates.index')"
                                    :active="
                                        route().current(
                                            'vat-rates.index',
                                        )
                                    "
                                >
                                    Contact: Functions
                                </DropdownLink>
                                <DropdownLink
                                    :href="route('vat-rates.index')"
                                    :active="
                                        route().current('vat-rates.index')
                                    "
                                >
                                    Finance:Vat Rates
                                </DropdownLink>
                            </div>
                        </template>
                    </Dropdown>
                </div>

                <!-- Right side navigation items -->
                <div class="flex items-center gap-2 ms-8">
                    <!-- Login/Register buttons for guest users -->
                    <template v-if="!$page.props.auth.user">
                        <Link
                            :href="route('login')"
                            class="rounded-full px-5 py-2 font-semibold text-blue-900 bg-blue-100 hover:bg-blue-200 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-[#FF2D20] dark:text-blue-100 dark:bg-blue-800 dark:hover:bg-blue-700 dark:focus-visible:ring-white shadow-sm"
                        >
                            Log in
                        </Link>
                        <Link
                            :href="route('register')"
                            class="rounded-full px-5 py-2 font-semibold text-blue-900 bg-blue-100 hover:bg-blue-200 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-[#FF2D20] dark:text-blue-100 dark:bg-blue-800 dark:hover:bg-blue-700 dark:focus-visible:ring-white shadow-sm"
                        >
                            Register
                        </Link>
                    </template>

                    <!-- Desktop Navigation Items -->
                    <div
                        v-if="$page.props.auth.user"
                        class="hidden sm:flex sm:items-center"
                    >
                        <!-- Teams Dropdown -->
                        <div
                            class="ms-3 relative"
                            v-if="$page.props.jetstream.hasTeamFeatures"
                        >
                            <Dropdown align="right" width="60">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button
                                            type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-full text-blue-900 bg-blue-100 hover:bg-blue-200 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-[#FF2D20] dark:text-blue-100 dark:bg-blue-800 dark:hover:bg-blue-700 dark:focus-visible:ring-white shadow-sm"
                                        >
                                            {{
                                                $page.props.auth.user
                                                    .current_team.name
                                            }}
                                            <svg
                                                class="ms-2 -me-0.5 size-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"
                                                />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <div class="w-60">
                                        <!-- Team Management -->
                                        <div
                                            class="block px-4 py-2 text-xs text-gray-400"
                                        >
                                            Manage Team
                                        </div>

                                        <!-- Team Settings -->
                                        <DropdownLink
                                            :href="
                                                route(
                                                    'teams.show',
                                                    $page.props.auth.user
                                                        .current_team,
                                                )
                                            "
                                        >
                                            Team Settings
                                        </DropdownLink>

                                        <DropdownLink
                                            v-if="
                                                $page.props.jetstream
                                                    .canCreateTeams
                                            "
                                            :href="route('teams.create')"
                                        >
                                            Create New Team
                                        </DropdownLink>

                                        <!-- Team Switcher -->
                                        <template
                                            v-if="
                                                $page.props.auth.user.all_teams
                                                    .length > 1
                                            "
                                        >
                                            <div
                                                class="border-t border-gray-200"
                                            />

                                            <div
                                                class="block px-4 py-2 text-xs text-gray-400"
                                            >
                                                Switch Teams
                                            </div>

                                            <template
                                                v-for="team in $page.props.auth
                                                    .user.all_teams"
                                                :key="team.id"
                                            >
                                                <form
                                                    @submit.prevent="
                                                        switchToTeam(team)
                                                    "
                                                >
                                                    <DropdownLink as="button">
                                                        <div
                                                            class="flex items-center"
                                                        >
                                                            <svg
                                                                v-if="
                                                                    team.id ==
                                                                    $page.props
                                                                        .auth
                                                                        .user
                                                                        .current_team_id
                                                                "
                                                                class="me-2 size-5 text-green-400"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                fill="none"
                                                                viewBox="0 0 24 24"
                                                                stroke-width="1.5"
                                                                stroke="currentColor"
                                                            >
                                                                <path
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                                                />
                                                            </svg>
                                                            <div>
                                                                {{ team.name }}
                                                            </div>
                                                        </div>
                                                    </DropdownLink>
                                                </form>
                                            </template>
                                        </template>
                                    </div>
                                </template>
                            </Dropdown>
                        </div>

                        <!-- Settings Dropdown -->
                        <div class="ms-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button
                                        v-if="
                                            $page.props.jetstream
                                                .managesProfilePhotos
                                        "
                                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition"
                                    >
                                        <img
                                            class="size-10 rounded-full object-cover"
                                            :src="
                                                $page.props.auth.user
                                                    .profile_photo_url
                                            "
                                            :alt="$page.props.auth.user.name"
                                        />
                                    </button>

                                    <span v-else class="inline-flex rounded-md">
                                        <button
                                            type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-full text-blue-900 bg-blue-100 hover:bg-blue-200 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-[#FF2D20] dark:text-blue-100 dark:bg-blue-800 dark:hover:bg-blue-700 dark:focus-visible:ring-white shadow-sm"
                                        >
                                            {{ $page.props.auth.user.name }}
                                            <svg
                                                class="ms-2 -me-0.5 size-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                                                />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <!-- Account Management -->
                                    <div
                                        class="block px-4 py-2 text-xs text-gray-400"
                                    >
                                        Manage Account
                                    </div>

                                    <DropdownLink :href="route('profile.show')">
                                        Profile
                                    </DropdownLink>

                                    <DropdownLink
                                        v-if="
                                            $page.props.jetstream.hasApiFeatures
                                        "
                                        :href="route('api-tokens.index')"
                                    >
                                        API Tokens
                                    </DropdownLink>

                                    <div class="border-t border-gray-200" />

                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button">
                                            Log Out
                                        </DropdownLink>
                                    </form>
                                </template>
                            </Dropdown>
                        </div>
                    </div>

                    <!-- Mobile Login/Register buttons -->
                    <div
                        v-if="!$page.props.auth.user"
                        class="sm:hidden flex gap-2"
                    >
                        <Link
                            :href="route('login')"
                            class="rounded-full px-3 py-1 text-sm font-semibold text-blue-900 bg-blue-100 hover:bg-blue-200 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-[#FF2D20] dark:text-blue-100 dark:bg-blue-800 dark:hover:bg-blue-700 dark:focus-visible:ring-white shadow-sm"
                        >
                            Log in
                        </Link>
                        <Link
                            :href="route('register')"
                            class="rounded-full px-3 py-1 text-sm font-semibold text-blue-900 bg-blue-100 hover:bg-blue-200 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-[#FF2D20] dark:text-blue-100 dark:bg-blue-800 dark:hover:bg-blue-700 dark:focus-visible:ring-white shadow-sm"
                        >
                            Register
                        </Link>
                    </div>

                    <!-- Hamburger -->
                    <div v-if="$page.props.auth.user" class="sm:hidden">
                        <button
                            class="inline-flex items-center justify-center p-2 rounded-full text-blue-200 hover:text-blue-100 hover:bg-blue-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#FF2D20] transition duration-150 ease-in-out"
                            @click="
                                showingNavigationDropdown =
                                    !showingNavigationDropdown
                            "
                        >
                            <svg
                                class="size-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex':
                                            !showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex':
                                            showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </nav>

            <!-- Responsive Navigation Menu -->
            <div
                v-if="$page.props.auth.user"
                :class="{
                    block: showingNavigationDropdown,
                    hidden: !showingNavigationDropdown,
                }"
                class="sm:hidden fixed top-16 left-0 right-0 z-20"
            >
                <div
                    class="pt-2 pb-3 space-y-1 bg-blue-900/90 dark:bg-blue-950/90"
                >
                    <ResponsiveNavLink
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                        class="text-blue-100 hover:bg-blue-800 hover:text-white"
                    >
                        Dashboard
                    </ResponsiveNavLink>
                </div>

                <!-- Responsive Settings Options -->
                <div
                    class="pt-4 pb-1 border-t border-blue-800 bg-blue-900/90 dark:bg-blue-950/90"
                >
                    <div class="flex items-center px-4">
                        <div
                            v-if="$page.props.jetstream.managesProfilePhotos"
                            class="shrink-0 me-3"
                        >
                            <img
                                class="size-10 rounded-full object-cover border-2 border-blue-300"
                                :src="$page.props.auth.user.profile_photo_url"
                                :alt="$page.props.auth.user.name"
                            />
                        </div>

                        <div>
                            <div class="font-medium text-base text-blue-100">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-blue-300">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink
                            :href="route('profile.show')"
                            :active="route().current('profile.show')"
                            class="text-blue-100 hover:bg-blue-800 hover:text-white"
                        >
                            Profile
                        </ResponsiveNavLink>

                        <ResponsiveNavLink
                            v-if="$page.props.jetstream.hasApiFeatures"
                            :href="route('api-tokens.index')"
                            :active="route().current('api-tokens.index')"
                            class="text-blue-100 hover:bg-blue-800 hover:text-white"
                        >
                            API Tokens
                        </ResponsiveNavLink>

                        <!-- Authentication -->
                        <form method="POST" @submit.prevent="logout">
                            <ResponsiveNavLink
                                as="button"
                                class="text-blue-100 hover:bg-blue-800 hover:text-white"
                            >
                                Log Out
                            </ResponsiveNavLink>
                        </form>

                        <!-- Team Management -->
                        <template v-if="$page.props.jetstream.hasTeamFeatures">
                            <div class="border-t border-gray-200" />

                            <div class="block px-4 py-2 text-xs text-gray-400">
                                Manage Team
                            </div>

                            <!-- Team Settings -->
                            <ResponsiveNavLink
                                :href="
                                    route(
                                        'teams.show',
                                        $page.props.auth.user.current_team,
                                    )
                                "
                                :active="route().current('teams.show')"
                                class="text-blue-100 hover:bg-blue-800 hover:text-white"
                            >
                                Team Settings
                            </ResponsiveNavLink>

                            <ResponsiveNavLink
                                v-if="$page.props.jetstream.canCreateTeams"
                                :href="route('teams.create')"
                                :active="route().current('teams.create')"
                                class="text-blue-100 hover:bg-blue-800 hover:text-white"
                            >
                                Create New Team
                            </ResponsiveNavLink>

                            <!-- Team Switcher -->
                            <template
                                v-if="
                                    $page.props.auth.user.all_teams.length > 1
                                "
                            >
                                <div class="border-t border-gray-200" />

                                <div
                                    class="block px-4 py-2 text-xs text-gray-400"
                                >
                                    Switch Teams
                                </div>

                                <template
                                    v-for="team in $page.props.auth.user
                                        .all_teams"
                                    :key="team.id"
                                >
                                    <form @submit.prevent="switchToTeam(team)">
                                        <ResponsiveNavLink
                                            as="button"
                                            class="text-blue-100 hover:bg-blue-800 hover:text-white"
                                        >
                                            <div class="flex items-center">
                                                <svg
                                                    v-if="
                                                        team.id ==
                                                        $page.props.auth.user
                                                            .current_team_id
                                                    "
                                                    class="me-2 size-5 text-green-400"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke-width="1.5"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                                    />
                                                </svg>
                                                <div>{{ team.name }}</div>
                                            </div>
                                        </ResponsiveNavLink>
                                    </form>
                                </template>
                            </template>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Page Content & Heading Aligned -->
            <main class="pt-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div v-if="$slots.header" class="mb-4 ms-0 sm:ms-8 mt-5">
                        <slot name="header" />
                    </div>
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
