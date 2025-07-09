<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { Folder, LayoutDashboard, History, PackageOpen, NotepadText, Archive, Boxes, Bolt, Notebook, Store, GlassWater, Flame, Cone } from 'lucide-vue-next';
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
                href: '/brewing-methods',
                icon: coffeemaker,
            },
            {
                title: 'Filters',
                href: '/filters',
                icon: Cone,
                iconClass: 'rotate-180'
            },
            {
                title: 'Grinders',
                href: '/grinders',
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
                href: '/brands',
                icon: Store,
            },
            {
                title: 'Batches',
                href: '/',
                icon: Boxes,
            },
            {
                title: 'My Coffees',
                href: '/coffees',
                icon: coffeeBean,
            },
            {
                title: 'Recipes',
                href: '/',
                icon: Notebook,
            },
            {
                title: 'Roast Levels',
                href: '/roast-levels',
                icon: Flame,
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
        children: [
            {
                title: 'My Inventory',
                href: '/',
                icon: PackageOpen,
            },
            {
                title: 'Container Types',
                href: '/container-types',
                icon: Archive,
            }
        ]
    },
    {
        title: 'Waters',
        href: '/waters',
        icon: GlassWater,
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
        href: 'https://github.com/leogil/sensorium',
        icon: Folder,
    }
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
