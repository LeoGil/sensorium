<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutDashboard, History, PackageOpen, NotepadText, PillBottle, Boxes, Bolt, Notebook, Store } from 'lucide-vue-next';
import { coffeeBean, coffeemaker, toolbox } from '@lucide/lab';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutDashboard,
    },
    {
        title: 'Equipments',
        href: '/',
        icon: toolbox,
        children: [
            {
                title: 'Brewing Methods',
                href: '/',
                icon: coffeemaker,
            },
            {
                title: 'Grinders',
                href: '/',
                icon: Bolt,
            }
        ],
    },
    {
        title: 'Coffees',
        href: '/',
        icon: coffeeBean,
        children: [
            {
                title: 'Brands',
                href: '/',
                icon: Store,
            },
            {
                title: 'Batches',
                href: '/',
                icon: Boxes,
            },
            {
                title: 'My Coffees',
                href: '/',
                icon: coffeeBean,
            },
            {
                title: 'Recipes',
                href: '/',
                icon: Notebook,
            }
        ]
    },
    {
        title: 'Extractions',
        href: '/',
        icon: History,
    },
    {
        title: 'Inventory',
        href: '/',
        icon: PackageOpen,
    },
    {
        title: 'Containers',
        href: '/',
        icon: PillBottle,
    },
    {
        title: 'Reports',
        href: '/',
        icon: NotepadText,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                        <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
