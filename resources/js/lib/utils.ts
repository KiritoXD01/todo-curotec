import { Updater } from '@tanstack/vue-table';
import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';
import { Ref } from 'vue';

export function cn(...inputs: ClassValue[]): string {
    return twMerge(clsx(inputs));
}

export function valueUpdater<T extends Updater<any>>(updateOfValue: T, ref: Ref): void {
    ref.value = typeof updateOfValue === 'function'
        ? updateOfValue(ref.value)
        : updateOfValue
}
