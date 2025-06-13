/**
 * Converts the first letter of a string to uppercase and returns the result
 * @param str - The input string to be processed
 * @returns The string with its first letter capitalized
 * @example
 * upperFirstLetter('hello') // returns 'Hello'
 * upperFirstLetter('world') // returns 'World'
 */
export function upperFirstLetter(str: string): string {
    if (!str) return '';
    return str.charAt(0).toUpperCase() + str.slice(1);
}

export function useUpperFirstLetter() {
    return { upperFirstLetter };
}
