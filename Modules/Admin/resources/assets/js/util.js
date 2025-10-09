import tinycolor from 'tinycolor2'
import _ from 'lodash'

export function colorMatch(color) {
    let defaultMap = {
        'red': [
            'border-color: rgb(var(--red-6))',
            'color: rgb(var(--red-6))',
            'background-color: rgb(var(--red-1))',
        ],
        'orangered': [
            'border-color: rgb(var(--orangered-6))',
            'color: rgb(var(--orangered-6))',
            'background-color: rgb(var(--orangered-1))',
        ],
        'orange': [
            'border-color: rgb(var(--orange-6))',
            'color: rgb(var(--orange-6))',
            'background-color: rgb(var(--orange-1))',
        ],
        'gold': [
            'border-color: rgb(var(--gold-6))',
            'color: rgb(var(--gold-6))',
            'background-color: rgb(var(--gold-1))',
        ],
        'lime': [
            'border-color: rgb(var(--lime-6))',
            'color: rgb(var(--lime-6))',
            'background-color: rgb(var(--lime-1))',
        ],
        'green': [
            'border-color: rgb(var(--green-6))',
            'color: rgb(var(--green-6))',
            'background-color: rgb(var(--green-1))',
        ],
        'cyan': [
            'border-color: rgb(var(--cyan-6))',
            'color: rgb(var(--cyan-6))',
            'background-color: rgb(var(--cyan-1))',
        ],
        'blue': [
            'border-color: rgb(var(--blue-6))',
            'color: rgb(var(--blue-6))',
            'background-color: rgb(var(--blue-1))',
        ],
        'arcoblue': [
            'border-color: rgb(var(--arcoblue-6))',
            'color: rgb(var(--arcoblue-6))',
            'background-color: rgb(var(--arcoblue-1))',
        ],
        'purple': [
            'border-color: rgb(var(--purple-6))',
            'color: rgb(var(--purple-6))',
            'background-color: rgb(var(--purple-1))',
        ],
        'pinkpurple': [
            'border-color: rgb(var(--pinkpurple-6))',
            'color: rgb(var(--pinkpurple-6))',
            'background-color: rgb(var(--pinkpurple-1))',
        ],
        'magenta': [
            'border-color: rgb(var(--magenta-6))',
            'color: rgb(var(--magenta-6))',
            'background-color: rgb(var(--magenta-1))',
        ],
        'gray': [
            'border-color: rgb(var(--gray-6))',
            'color: rgb(var(--gray-6))',
            'background-color: rgb(var(--gray-1))',
        ],
    };



    if (color && color.startsWith('#')) {
        let baseColor = tinycolor(color)
        if (baseColor.isLight()) {
            baseColor = baseColor.darken(50)
        } else {
            baseColor = baseColor.lighten(50)
        }
        const contrastColor = baseColor.toHexString()
        return [
            'border-color: ' + contrastColor,
            'color: ' + contrastColor,
            'background-color: ' + color,
        ];
    }

    return defaultMap[color] ?? [];
}

export function recursiveMap(arr, iteratee, children_key = 'children') {
    return _.map(arr, (item, key) => {
        if (item[children_key] && item[children_key].length) {
            item[children_key] = recursiveMap(item[children_key], iteratee)
        }
        return iteratee(item, key)
    });
}

export function recursiveFilter(arr, iteratee, children_key = 'children') {
    return _.filter(arr, (item, key) => {
        if (item[children_key] && item[children_key].length) {
            item[children_key] = recursiveFilter(item[children_key], iteratee)
        }
        return iteratee(item, key)
    });
}

export function recursiveForEach(arr, iteratee, children_key = 'children', parent = null) {
    _.forEach(arr, (item, key) => {
        iteratee(item, key, parent)
        if (item[children_key] && item[children_key].length) {
            recursiveForEach(item[children_key], iteratee, children_key, item)
        }
    });
}

export function openFullscreen() {
    const elem = document.getElementsByTagName('html')[0]
    // 标准方法
    if (elem.requestFullscreen) {
        elem.requestFullscreen();
    }
    // WebKit内核浏览器
    else if (elem.webkitRequestFullscreen) {
        elem.webkitRequestFullscreen();
    }
    // Firefox
    else if (elem.mozRequestFullScreen) {
        elem.mozRequestFullScreen();
    }
    // IE/Edge
    else if (elem.msRequestFullscreen) {
        elem.msRequestFullscreen();
    }
}

// 退出全屏函数
export function closeFullscreen() {
    // 标准方法
    if (document.exitFullscreen) {
        document.exitFullscreen();
    }
    // WebKit内核浏览器
    else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
    }
    // Firefox
    else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
    }
    // IE/Edge
    else if (document.msExitFullscreen) {
        document.msExitFullscreen();
    }
}

export function isFullscreen() {
    return document.fullscreenElement ||
        document.webkitFullscreenElement ||
        document.mozFullScreenElement ||
        document.msFullscreenElement || (window.innerWidth === screen.width && window.innerHeight === screen.height)
}

export function changeFullScreen() {
    if (isFullscreen()) {
        closeFullscreen()
    } else {
        openFullscreen()
    }
}

export function globalCursorProgress() {
    const el = document.getElementById('global-cursor')
    if(!el) {
        const cursor = document.createElement('style')
        cursor.id = 'global-cursor'
        cursor.innerHTML = `
            * {
                cursor: progress !important;
            }
        `
        document.head.appendChild(cursor)
    }
    const iframes = document.getElementsByTagName('iframe')
    _.forEach(iframes, function(item) {
        let cursor = item.contentWindow.document.getElementById('global-cursor')
        if (!cursor) {
            cursor = document.createElement('style')
            cursor.id = 'global-cursor'
            cursor.innerHTML = `
                * {
                    cursor: progress !important;
                }
            `
            item.contentWindow.document.head.appendChild(cursor)
        }
    })
}

export function globalCursorDefault() {
    const el = document.getElementById('global-cursor')
    if(el) {
        el.remove()
    }
    const iframes = document.getElementsByTagName('iframe')
    _.forEach(iframes, function(item) {
        let cursor = item.contentWindow.document.getElementById('global-cursor')
        if(cursor) {
            cursor.remove()
        }
    })
}