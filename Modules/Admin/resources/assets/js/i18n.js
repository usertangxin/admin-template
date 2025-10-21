import { computed, nextTick } from 'vue'
import { useI18n } from 'vue-i18n'

let i18nCache = null

function getI18n() {
  if (!i18nCache) {
    i18nCache = useI18n()
  }
  return i18nCache
}

export function __(key) {
  const { t } = getI18n()
  return computed(() => t(key))
}

export function t(key, options = {}) {
  const a = getI18n()
  return a.t(key, options)
}



export function setI18nLanguage(i18n, locale) {
  if (i18n.mode === 'legacy') {
    i18n.global.locale = locale
  } else {
    i18n.global.locale.value = locale
  }
  document.querySelector('html').setAttribute('lang', locale)
}

export async function loadLocaleMessages(i18n, locale) {
  const messages = import.meta.glob(`/Modules/**/resources/assets/js/locales/*.json`)

  let moduleMessages = {}
  for (const path in messages) {
    if (path.includes(locale + '.json')) {
      const moduleMessage = await messages[path]()
      moduleMessages = { ...moduleMessages, ...moduleMessage.default }
    }
  }

  const appMessages = import.meta.glob(`/resources/js/locales/*.json`)
  
  for (const path in appMessages) {
    if (path.includes(locale + '.json')) {
      const appMessage = await appMessages[path]()
      moduleMessages = { ...moduleMessages, ...appMessage.default }
    }
  }

  // console.log(locale, moduleMessages)

  i18n.global.setLocaleMessage(locale, moduleMessages)

  return nextTick()
}