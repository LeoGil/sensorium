import type { IconNode, LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon: LucideIcon | IconNode;
    isActive?: boolean;
    children?: NavItem[];
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface Brand {
    id: number;
    user_id: number;
    logo: string;
    name: string;
    url: string;
    created_at: string;
    updated_at: string;
}

export interface Coffee {
    id: number;
    user_id: number;
    name: string;
    description?: string;
    sensory?: string;
    farm?: string;
    variety?: string;
    region?: string;
    altitude?: number | null;
    producer?: string;
    processing_method?: string;
    roaster?: string;
    brand_id: number;
    image?: string;
    image_url?: string;
    roast_level_id: number;
    created_at: string;
    updated_at: string;
}

export interface RoastLevel {
    id: number;
    user_id: number;
    name: string;
    description?: string;
    created_at: string;
    updated_at: string;
}

export type BreadcrumbItemType = BreadcrumbItem;
