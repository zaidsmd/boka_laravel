import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import obfuscator from "rollup-plugin-obfuscator";


const boostrap = [

]
const css = [
    'resources/css/app.scss'
]
const js = [
    'resources/js/app.js',
    'resources/js/shop.js',
    'resources/js/admin.js',

    'resources/js/category.js',
    'resources/js/new.js',
    'resources/js/best-seller.js',
    'resources/js/sale.js',
]

export default defineConfig({
    plugins: [
        laravel({
            input: [...boostrap,...css,...js],
            refresh: true,
        }),
        obfuscator({
            options: {
                compact: true,
                controlFlowFlattening: true,
                controlFlowFlatteningThreshold: 0.75,
                deadCodeInjection: false,
                deadCodeInjectionThreshold: 0.4,
                debugProtection: false,
                debugProtectionInterval: 0,
                disableConsoleOutput: false,
                domainLock: [],
                domainLockRedirectUrl: "about:blank",
                forceTransformStrings: [],
                identifierNamesCache: null,
                identifierNamesGenerator: "mangled-shuffled",
                identifiersDictionary: [],
                identifiersPrefix: "gero",
                ignoreImports: false,
                inputFileName: "",
                log: false,
                numbersToExpressions: false,
                optionsPreset: "medium-obfuscation",
                renameGlobals: false,
                renameProperties: false,
                renamePropertiesMode: "safe",
                reservedNames: [],
                reservedStrings: [],
                seed: 0,
                selfDefending: false,
                simplify: true,
                sourceMap: false,
                sourceMapBaseUrl: "",
                sourceMapFileName: "",
                sourceMapMode: "separate",
                sourceMapSourcesMode: "sources-content",
                splitStrings: false,
                splitStringsChunkLength: 10,
                stringArray: true,
                stringArrayCallsTransform: true,
                stringArrayCallsTransformThreshold: 0.75,
                stringArrayEncoding: ["base64"],
                stringArrayIndexesType: ["hexadecimal-number"],
                stringArrayIndexShift: true,
                stringArrayRotate: true,
                stringArrayShuffle: true,
                stringArrayWrappersCount: 1,
                stringArrayWrappersChainedCalls: true,
                stringArrayWrappersParametersMaxCount: 2,
                stringArrayWrappersType: "variable",
                stringArrayThreshold: 0.75,
                target: "browser",
                transformObjectKeys: false,
                unicodeEscapeSequence: false,
            },
        }),
    ],
});
