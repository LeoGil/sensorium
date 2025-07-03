<script setup lang="ts">
import {
    Pagination,
    PaginationContent,
    PaginationFirst,
    PaginationLast,
    PaginationItem,
} from '@/components/ui/pagination'

import { router } from '@inertiajs/vue3'

interface Props {
    currentPage: number
    perPage: number
    total: number
}

const props = defineProps<Props>()

function getCurrentParams(): Record<string, any> {
    const params = new URLSearchParams(window.location.search)
    const obj: Record<string, string> = {}
    params.forEach((v, k) => {
        obj[k] = v
    })
    return obj
}

function goToPage(page: number) {
    const lastPage = Math.ceil(props.total / props.perPage)
    if (page < 1 || page > lastPage) return

    const params = getCurrentParams()
    params.page = String(page)

    router.visit(window.location.pathname, {
        method: 'get',
        preserveScroll: true,
        preserveState: true,
        data: params,
    })
}
</script>

<template>
    <Pagination v-slot="{ page }" :default-page="currentPage" :items-per-page="perPage" :total="total"
        @update:page="goToPage">
        <PaginationContent v-slot="{ items }">
            <PaginationFirst />

            <template v-for="(item, idx) in items" :key="idx">
                <PaginationItem v-if="item.type === 'page'" :value="item.value" :is-active="item.value === page">
                    {{ item.value }}
                </PaginationItem>
            </template>

            <PaginationLast />
        </PaginationContent>
    </Pagination>
</template>
