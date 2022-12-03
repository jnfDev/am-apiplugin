/**
 * A wrapper for AmAdminVars.i18n
 * @param {String} text 
 * @returns String
 */
export const __ = (text) => {
    const { i18n } = AmAdminVars;
    const translation = i18n[text]

    if (! translation) {
        return text;
    }

    return translation;
}

/**
 * @NOTE: I tried to follow the official approach explained here: 
 * https://developer.wordpress.org/apis/internationalization/#internationalizing-javascript
 * 
 * However, it didn't work in this use case, so I had to implement a workaround.
 */