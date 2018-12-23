import Vue from 'vue'
import hljs from 'highlight.js/lib/highlight';

import javascript from 'highlight.js/lib/languages/javascript';
hljs.registerLanguage('javascript', javascript);

import php from 'highlight.js/lib/languages/php';
hljs.registerLanguage('php', php);

import bash from 'highlight.js/lib/languages/bash';
hljs.registerLanguage('bash', bash);

import nginx from 'highlight.js/lib/languages/nginx';
hljs.registerLanguage('nginx', nginx);

import css from 'highlight.js/lib/languages/css';
hljs.registerLanguage('css', css);
// import 'highlight.js/styles/ir-black.css'
// import 'highlight.js/styles/nord.css'
import 'highlight.js/styles/tomorrow-night-bright.css'

Vue.directive('highlightjs', {
    deep: true,
    bind: function (el, binding) {
        // on first bind, highlight all targets
        setTimeout(() => {
            let targets = el.querySelectorAll('pre code')
            targets.forEach((target) => {
                // if a value is directly assigned to the directive, use this
                // instead of the element content.
                if (binding.value) {
                    target.innerHTML = binding.value
                }
                hljs.highlightBlock(target)
            })
        }, 300);

    },
    componentUpdated: function (el, binding) {
        setTimeout(() => {
            let targets = el.querySelectorAll('pre code')
            targets.forEach((target) => {
                // if a value is directly assigned to the directive, use this
                // instead of the element content.
                if (binding.value) {
                    target.innerHTML = binding.value
                }
                hljs.highlightBlock(target)
            })
        }, 300);
    }
})
