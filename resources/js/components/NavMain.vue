<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
import { Icon, ChevronRight } from 'lucide-vue-next'

import {
    Collapsible,
    CollapsibleTrigger,
    CollapsibleContent,
} from '@/components/ui/collapsible'

import {
    SidebarGroup,
    SidebarMenu,
    SidebarMenuItem,
    SidebarMenuButton,
    SidebarMenuSub,
    SidebarMenuSubItem,
    SidebarMenuSubButton,
} from '@/components/ui/sidebar'

import type { NavItem } from '@/types'

withDefaults(defineProps<{
    items: NavItem[]
}>(), {
    items: () => [],
})

const page = usePage()

function isActive(href: string) {
    return page.url.split('?')[0] === href
}
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarMenu>
            <template v-for="item in items" :key="item.title">
                <Collapsible v-if="item.children && item.children.length"
                    :default-open="isActive(item.href) || item.children.some(c => isActive(c.href))" as-child
                    class="group/collapsible">
                    <SidebarMenuItem>
                        <CollapsibleTrigger as-child>
                            <SidebarMenuButton :tooltip="item.title" :is-active="isActive(item.href)">
                                <component
                                    v-if="typeof item.icon === 'function' || (typeof item.icon === 'object' && 'length' in item.icon) && !item.icon?.length"
                                    :is="item.icon" class="mr-2" :class="item.iconClass" />
                                <Icon v-else :is="Icon" :iconNode="item.icon" class="mr-2" />
                                <span>{{ item.title }}</span>
                                <ChevronRight
                                    class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90" />
                            </SidebarMenuButton>
                        </CollapsibleTrigger>

                        <CollapsibleContent>
                            <SidebarMenuSub>
                                <SidebarMenuSubItem v-for="sub in item.children" :key="sub.title">
                                    <SidebarMenuSubButton as-child :is-active="isActive(sub.href)">
                                        <Link :href="sub.href" class="flex items-center space-x-2">
                                        <component
                                            v-if="typeof sub.icon === 'function' || typeof sub.icon === 'object' && !sub.icon?.length"
                                            :is="sub.icon" :class="sub.iconClass" />
                                        <Icon v-else :is="Icon" :iconNode="sub.icon" />
                                        <span>{{ sub.title }}</span>
                                        </Link>
                                    </SidebarMenuSubButton>
                                </SidebarMenuSubItem>
                            </SidebarMenuSub>
                        </CollapsibleContent>
                    </SidebarMenuItem>
                </Collapsible>
                <SidebarMenuItem v-else>
                    <SidebarMenuButton :is-active="isActive(item.href)" as-child :tooltip="item.title">
                        <Link :href="item.href" class="flex items-center space-x-2">
                        <component
                            v-if="typeof item.icon === 'function' || typeof item.icon === 'object' && !item.icon?.length"
                            :is="item.icon" class="mr-2" :class="item.iconClass" />
                        <Icon v-else :is="Icon" :iconNode="item.icon" class="mr-2" />
                        <span>{{ item.title }}</span>
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </template>
        </SidebarMenu>
    </SidebarGroup>
</template>
