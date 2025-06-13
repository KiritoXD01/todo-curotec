import { TaskStatusEnum, TaskTypeEnum } from '@/enums/enums';
import type { LucideIcon } from 'lucide-vue-next';
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
    icon?: LucideIcon;
    isActive?: boolean;
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

export interface Category {
    id: number;
    name: string;
    parent_id: number | null;
    parent_name: string | null;
    created_at: string;
    updated_at: string;
}

export interface Task {
    id: number;
    uuid: string;
    title: string;
    description: string | null;
    due_date: string | null;
    priority: TaskTypeEnum;
    status: TaskStatusEnum;
    category: string | null;
    subcategory: string | null;
    category_id: number | null;
    subcategory_id: number | null;
    created_at: string;
    updated_at: string;
}

export interface Pagination<T> {
    links: {
        first: string | null;
        last: string | null;
        next: string | null;
        prev: string | null;
    };
    data: T[];
    meta: {
        current_page: number;
        current_page_url: string;
        from: number;
        path: string;
        per_page: number;
        to: number;
        total: number;
    };
}

export type BreadcrumbItemType = BreadcrumbItem;
export type ModeOptions = 'create' | 'edit';
