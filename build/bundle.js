(()=>{"use strict";const e=wp.components;var t=["onClick","label"];function r(){return r=Object.assign?Object.assign.bind():function(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var a in r)({}).hasOwnProperty.call(r,a)&&(e[a]=r[a])}return e},r.apply(null,arguments)}var a=function(a){var n=[{label:"Editar",onClick:a.onEditClick,variant:"primary",size:"small"},{label:"Eliminar",onClick:a.onDeleteClick,variant:"secondary",size:"small"}];return React.createElement("div",null,function(a){return null!=a&&a.length?React.createElement(e.ButtonGroup,null,a.map((function(a,n){var s=a.onClick,i=a.label,l=function(e,t){if(null==e)return{};var r,a,n=function(e,t){if(null==e)return{};var r={};for(var a in e)if({}.hasOwnProperty.call(e,a)){if(t.includes(a))continue;r[a]=e[a]}return r}(e,t);if(Object.getOwnPropertySymbols){var s=Object.getOwnPropertySymbols(e);for(a=0;a<s.length;a++)r=s[a],t.includes(r)||{}.propertyIsEnumerable.call(e,r)&&(n[r]=e[r])}return n}(a,t);return console.log({label:i,index:n}),React.createElement(e.Button,r({key:n,onClick:s},l),i)}))):null}(n))};const n=wp.element,s=React;var i=e=>"checkbox"===e.type,l=e=>e instanceof Date,o=e=>null==e;const u=e=>"object"==typeof e;var c=e=>!o(e)&&!Array.isArray(e)&&u(e)&&!l(e),d=e=>{const t=e.constructor&&e.constructor.prototype;return c(t)&&t.hasOwnProperty("isPrototypeOf")},f="undefined"!=typeof window&&void 0!==window.HTMLElement&&"undefined"!=typeof document;function m(e){let t;const r=Array.isArray(e);if(e instanceof Date)t=new Date(e);else if(e instanceof Set)t=new Set(e);else{if(f&&(e instanceof Blob||e instanceof FileList)||!r&&!c(e))return e;if(t=r?[]:{},r||d(e))for(const r in e)e.hasOwnProperty(r)&&(t[r]=m(e[r]));else t=e}return t}var y=e=>Array.isArray(e)?e.filter(Boolean):[],v=e=>void 0===e,b=(e,t,r)=>{if(!t||!c(e))return r;const a=y(t.split(/[,[\].]+?/)).reduce(((e,t)=>o(e)?e:e[t]),e);return v(a)||a===e?v(e[t])?r:e[t]:a},g=e=>"boolean"==typeof e,p=e=>/^\w*$/.test(e),h=e=>y(e.replace(/["|']|\]/g,"").split(/\.|\[/)),_=(e,t,r)=>{let a=-1;const n=p(t)?[t]:h(t),s=n.length,i=s-1;for(;++a<s;){const t=n[a];let s=r;if(a!==i){const r=e[t];s=c(r)||Array.isArray(r)?r:isNaN(+n[a+1])?{}:[]}if("__proto__"===t)return;e[t]=s,e=e[t]}return e};const x="blur",A="focusout",V="onBlur",E="onChange",w="onSubmit",F="onTouched",S="all",k="pattern",D="required";s.createContext(null);var C=e=>c(e)&&!Object.keys(e).length,T=e=>Array.isArray(e)?e:[e];var O=e=>"string"==typeof e,R=(e,t,r,a,n)=>t?{...r[e],types:{...r[e]&&r[e].types?r[e].types:{},[a]:n||!0}}:{},q=e=>({isOnSubmit:!e||e===w,isOnBlur:e===V,isOnChange:e===E,isOnAll:e===S,isOnTouch:e===F}),j=(e,t,r)=>!r&&(t.watchAll||t.watch.has(e)||[...t.watch].some((t=>e.startsWith(t)&&/^\.\w+/.test(e.slice(t.length)))));const N=(e,t,r,a)=>{for(const n of r||Object.keys(e)){const r=b(e,n);if(r){const{_f:e,...s}=r;if(e){if(e.refs&&e.refs[0]&&t(e.refs[0],n)&&!a)return!0;if(e.ref&&t(e.ref,e.name)&&!a)return!0;if(N(s,t))break}else if(c(s)&&N(s,t))break}}};var L=(e,t,r)=>{const a=T(b(e,r));return _(a,"root",t[r]),_(e,r,a),e},P=e=>"file"===e.type,M=e=>"function"==typeof e,B=e=>{if(!f)return!1;const t=e?e.ownerDocument:0;return e instanceof(t&&t.defaultView?t.defaultView.HTMLElement:HTMLElement)},U=e=>O(e),I=e=>"radio"===e.type,G=e=>e instanceof RegExp;const $={value:!1,isValid:!1},z={value:!0,isValid:!0};var H=e=>{if(Array.isArray(e)){if(e.length>1){const t=e.filter((e=>e&&e.checked&&!e.disabled)).map((e=>e.value));return{value:t,isValid:!!t.length}}return e[0].checked&&!e[0].disabled?e[0].attributes&&!v(e[0].attributes.value)?v(e[0].value)||""===e[0].value?z:{value:e[0].value,isValid:!0}:z:$}return $};const W={isValid:!1,value:null};var J=e=>Array.isArray(e)?e.reduce(((e,t)=>t&&t.checked&&!t.disabled?{isValid:!0,value:t.value}:e),W):W;function K(e,t,r="validate"){if(U(e)||Array.isArray(e)&&e.every(U)||g(e)&&!e)return{type:r,message:U(e)?e:"",ref:t}}var Q=e=>c(e)&&!G(e)?e:{value:e,message:""},X=async(e,t,r,a,n)=>{const{ref:s,refs:l,required:u,maxLength:d,minLength:f,min:m,max:y,pattern:p,validate:h,name:_,valueAsNumber:x,mount:A,disabled:V}=e._f,E=b(t,_);if(!A||V)return{};const w=l?l[0]:s,F=e=>{a&&w.reportValidity&&(w.setCustomValidity(g(e)?"":e||""),w.reportValidity())},S={},T=I(s),q=i(s),j=T||q,N=(x||P(s))&&v(s.value)&&v(E)||B(s)&&""===s.value||""===E||Array.isArray(E)&&!E.length,L=R.bind(null,_,r,S),$=(e,t,r,a="maxLength",n="minLength")=>{const i=e?t:r;S[_]={type:e?a:n,message:i,ref:s,...L(e?a:n,i)}};if(n?!Array.isArray(E)||!E.length:u&&(!j&&(N||o(E))||g(E)&&!E||q&&!H(l).isValid||T&&!J(l).isValid)){const{value:e,message:t}=U(u)?{value:!!u,message:u}:Q(u);if(e&&(S[_]={type:D,message:t,ref:w,...L(D,t)},!r))return F(t),S}if(!(N||o(m)&&o(y))){let e,t;const a=Q(y),n=Q(m);if(o(E)||isNaN(E)){const r=s.valueAsDate||new Date(E),i=e=>new Date((new Date).toDateString()+" "+e),l="time"==s.type,o="week"==s.type;O(a.value)&&E&&(e=l?i(E)>i(a.value):o?E>a.value:r>new Date(a.value)),O(n.value)&&E&&(t=l?i(E)<i(n.value):o?E<n.value:r<new Date(n.value))}else{const r=s.valueAsNumber||(E?+E:E);o(a.value)||(e=r>a.value),o(n.value)||(t=r<n.value)}if((e||t)&&($(!!e,a.message,n.message,"max","min"),!r))return F(S[_].message),S}if((d||f)&&!N&&(O(E)||n&&Array.isArray(E))){const e=Q(d),t=Q(f),a=!o(e.value)&&E.length>+e.value,n=!o(t.value)&&E.length<+t.value;if((a||n)&&($(a,e.message,t.message),!r))return F(S[_].message),S}if(p&&!N&&O(E)){const{value:e,message:t}=Q(p);if(G(e)&&!E.match(e)&&(S[_]={type:k,message:t,ref:s,...L(k,t)},!r))return F(t),S}if(h)if(M(h)){const e=K(await h(E,t),w);if(e&&(S[_]={...e,...L("validate",e.message)},!r))return F(e.message),S}else if(c(h)){let e={};for(const a in h){if(!C(e)&&!r)break;const n=K(await h[a](E,t),w,a);n&&(e={...n,...L(a,n.message)},F(n.message),r&&(S[_]=e))}if(!C(e)&&(S[_]={ref:w,...e},!r))return S}return F(!0),S};function Y(e,t){const r=Array.isArray(t)?t:p(t)?[t]:h(t),a=1===r.length?e:function(e,t){const r=t.slice(0,-1).length;let a=0;for(;a<r;)e=v(e)?a++:e[t[a++]];return e}(e,r),n=r.length-1,s=r[n];return a&&delete a[s],0!==n&&(c(a)&&C(a)||Array.isArray(a)&&function(e){for(const t in e)if(e.hasOwnProperty(t)&&!v(e[t]))return!1;return!0}(a))&&Y(e,r.slice(0,-1)),e}var Z=()=>{let e=[];return{get observers(){return e},next:t=>{for(const r of e)r.next&&r.next(t)},subscribe:t=>(e.push(t),{unsubscribe:()=>{e=e.filter((e=>e!==t))}}),unsubscribe:()=>{e=[]}}},ee=e=>o(e)||!u(e);function te(e,t){if(ee(e)||ee(t))return e===t;if(l(e)&&l(t))return e.getTime()===t.getTime();const r=Object.keys(e),a=Object.keys(t);if(r.length!==a.length)return!1;for(const n of r){const r=e[n];if(!a.includes(n))return!1;if("ref"!==n){const e=t[n];if(l(r)&&l(e)||c(r)&&c(e)||Array.isArray(r)&&Array.isArray(e)?!te(r,e):r!==e)return!1}}return!0}var re=e=>"select-multiple"===e.type,ae=e=>B(e)&&e.isConnected,ne=e=>{for(const t in e)if(M(e[t]))return!0;return!1};function se(e,t={}){const r=Array.isArray(e);if(c(e)||r)for(const r in e)Array.isArray(e[r])||c(e[r])&&!ne(e[r])?(t[r]=Array.isArray(e[r])?[]:{},se(e[r],t[r])):o(e[r])||(t[r]=!0);return t}function ie(e,t,r){const a=Array.isArray(e);if(c(e)||a)for(const a in e)Array.isArray(e[a])||c(e[a])&&!ne(e[a])?v(t)||ee(r[a])?r[a]=Array.isArray(e[a])?se(e[a],[]):{...se(e[a])}:ie(e[a],o(t)?{}:t[a],r[a]):r[a]=!te(e[a],t[a]);return r}var le=(e,t)=>ie(e,t,se(t)),oe=(e,{valueAsNumber:t,valueAsDate:r,setValueAs:a})=>v(e)?e:t?""===e?NaN:e?+e:e:r&&O(e)?new Date(e):a?a(e):e;function ue(e){const t=e.ref;if(!(e.refs?e.refs.every((e=>e.disabled)):t.disabled))return P(t)?t.files:I(t)?J(e.refs).value:re(t)?[...t.selectedOptions].map((({value:e})=>e)):i(t)?H(e.refs).value:oe(v(t.value)?e.ref.value:t.value,e)}var ce=e=>v(e)?e:G(e)?e.source:c(e)?G(e.value)?e.value.source:e.value:e;const de="AsyncFunction";function fe(e,t,r){const a=b(e,r);if(a||p(r))return{error:a,name:r};const n=r.split(".");for(;n.length;){const a=n.join("."),s=b(t,a),i=b(e,a);if(s&&!Array.isArray(s)&&r!==a)return{name:r};if(i&&i.type)return{name:a,error:i};n.pop()}return{name:r}}const me={mode:w,reValidateMode:E,shouldFocusError:!0};function ye(e={}){let t,r={...me,...e},a={submitCount:0,isDirty:!1,isLoading:M(r.defaultValues),isValidating:!1,isSubmitted:!1,isSubmitting:!1,isSubmitSuccessful:!1,isValid:!1,touchedFields:{},dirtyFields:{},validatingFields:{},errors:r.errors||{},disabled:r.disabled||!1},n={},s=(c(r.defaultValues)||c(r.values))&&m(r.defaultValues||r.values)||{},u=r.shouldUnregister?{}:m(s),d={action:!1,mount:!1,watch:!1},p={mount:new Set,unMount:new Set,array:new Set,watch:new Set},h=0;const V={isDirty:!1,dirtyFields:!1,validatingFields:!1,touchedFields:!1,isValidating:!1,isValid:!1,errors:!1},E={values:Z(),array:Z(),state:Z()},w=q(r.mode),F=q(r.reValidateMode),k=r.criteriaMode===S,D=async e=>{if(V.isValid||e){const e=r.resolver?C((await $()).errors):await z(n,!0);e!==a.isValid&&E.state.next({isValid:e})}},R=(e,t)=>{(V.isValidating||V.validatingFields)&&((e||Array.from(p.mount)).forEach((e=>{e&&(t?_(a.validatingFields,e,t):Y(a.validatingFields,e))})),E.state.next({validatingFields:a.validatingFields,isValidating:!C(a.validatingFields)}))},U=(e,t,r,a)=>{const i=b(n,e);if(i){const n=b(u,e,v(r)?b(s,e):r);v(n)||a&&a.defaultChecked||t?_(u,e,t?n:ue(i._f)):J(e,n),d.mount&&D()}},G=(e,t,r,i,l)=>{let o=!1,u=!1;const c={name:e},d=!!(b(n,e)&&b(n,e)._f&&b(n,e)._f.disabled);if(!r||i){V.isDirty&&(u=a.isDirty,a.isDirty=c.isDirty=H(),o=u!==c.isDirty);const r=d||te(b(s,e),t);u=!(d||!b(a.dirtyFields,e)),r||d?Y(a.dirtyFields,e):_(a.dirtyFields,e,!0),c.dirtyFields=a.dirtyFields,o=o||V.dirtyFields&&u!==!r}if(r){const t=b(a.touchedFields,e);t||(_(a.touchedFields,e,r),c.touchedFields=a.touchedFields,o=o||V.touchedFields&&t!==r)}return o&&l&&E.state.next(c),o?c:{}},$=async e=>{R(e,!0);const t=await r.resolver(u,r.context,((e,t,r,a)=>{const n={};for(const r of e){const e=b(t,r);e&&_(n,r,e._f)}return{criteriaMode:r,names:[...e],fields:n,shouldUseNativeValidation:a}})(e||p.mount,n,r.criteriaMode,r.shouldUseNativeValidation));return R(e),t},z=async(e,t,n={valid:!0})=>{for(const i in e){const l=e[i];if(l){const{_f:e,...o}=l;if(e){const o=p.array.has(e.name),d=l._f&&!((s=l._f)&&s.validate||!(M(s.validate)&&s.validate.constructor.name===de||c(s.validate)&&Object.values(s.validate).find((e=>e.constructor.name===de))));d&&V.validatingFields&&R([i],!0);const f=await X(l,u,k,r.shouldUseNativeValidation&&!t,o);if(d&&V.validatingFields&&R([i]),f[e.name]&&(n.valid=!1,t))break;!t&&(b(f,e.name)?o?L(a.errors,f,e.name):_(a.errors,e.name,f[e.name]):Y(a.errors,e.name))}!C(o)&&await z(o,t,n)}}var s;return n.valid},H=(e,t)=>(e&&t&&_(u,e,t),!te(ye(),s)),W=(e,t,r)=>((e,t,r,a,n)=>O(e)?(a&&t.watch.add(e),b(r,e,n)):Array.isArray(e)?e.map((e=>(a&&t.watch.add(e),b(r,e)))):(a&&(t.watchAll=!0),r))(e,p,{...d.mount?u:v(t)?s:O(e)?{[e]:t}:t},r,t),J=(e,t,r={})=>{const a=b(n,e);let s=t;if(a){const r=a._f;r&&(!r.disabled&&_(u,e,oe(t,r)),s=B(r.ref)&&o(t)?"":t,re(r.ref)?[...r.ref.options].forEach((e=>e.selected=s.includes(e.value))):r.refs?i(r.ref)?r.refs.length>1?r.refs.forEach((e=>(!e.defaultChecked||!e.disabled)&&(e.checked=Array.isArray(s)?!!s.find((t=>t===e.value)):s===e.value))):r.refs[0]&&(r.refs[0].checked=!!s):r.refs.forEach((e=>e.checked=e.value===s)):P(r.ref)?r.ref.value="":(r.ref.value=s,r.ref.type||E.values.next({name:e,values:{...u}})))}(r.shouldDirty||r.shouldTouch)&&G(e,s,r.shouldTouch,r.shouldDirty,!0),r.shouldValidate&&ie(e)},K=(e,t,r)=>{for(const a in t){const s=t[a],i=`${e}.${a}`,o=b(n,i);!p.array.has(e)&&ee(s)&&(!o||o._f)||l(s)?J(i,s,r):K(i,s,r)}},Q=(e,t,r={})=>{const i=b(n,e),l=p.array.has(e),c=m(t);_(u,e,c),l?(E.array.next({name:e,values:{...u}}),(V.isDirty||V.dirtyFields)&&r.shouldDirty&&E.state.next({name:e,dirtyFields:le(s,u),isDirty:H(e,c)})):!i||i._f||o(c)?J(e,c,r):K(e,c,r),j(e,p)&&E.state.next({...a}),E.values.next({name:d.mount?e:void 0,values:{...u}})},ne=async s=>{d.mount=!0;const l=s.target;let o=l.name,f=!0;const m=b(n,o),y=e=>{f=Number.isNaN(e)||te(e,b(u,o,e))};if(m){let d,S;const T=l.type?ue(m._f):(e=>c(e)&&e.target?i(e.target)?e.target.checked:e.target.value:e)(s),O=s.type===x||s.type===A,q=!((v=m._f).mount&&(v.required||v.min||v.max||v.maxLength||v.minLength||v.pattern||v.validate)||r.resolver||b(a.errors,o)||m._f.deps)||((e,t,r,a,n)=>!n.isOnAll&&(!r&&n.isOnTouch?!(t||e):(r?a.isOnBlur:n.isOnBlur)?!e:!(r?a.isOnChange:n.isOnChange)||e))(O,b(a.touchedFields,o),a.isSubmitted,F,w),N=j(o,p,O);_(u,o,T),O?(m._f.onBlur&&m._f.onBlur(s),t&&t(0)):m._f.onChange&&m._f.onChange(s);const L=G(o,T,O,!1),P=!C(L)||N;if(!O&&E.values.next({name:o,type:s.type,values:{...u}}),q)return V.isValid&&("onBlur"===e.mode?O&&D():D()),P&&E.state.next({name:o,...N?{}:L});if(!O&&N&&E.state.next({...a}),r.resolver){const{errors:e}=await $([o]);if(y(T),f){const t=fe(a.errors,n,o),r=fe(e,n,t.name||o);d=r.error,o=r.name,S=C(e)}}else R([o],!0),d=(await X(m,u,k,r.shouldUseNativeValidation))[o],R([o]),y(T),f&&(d?S=!1:V.isValid&&(S=await z(n,!0)));f&&(m._f.deps&&ie(m._f.deps),((r,n,s,i)=>{const l=b(a.errors,r),o=V.isValid&&g(n)&&a.isValid!==n;var u;if(e.delayError&&s?(u=()=>((e,t)=>{_(a.errors,e,t),E.state.next({errors:a.errors})})(r,s),t=e=>{clearTimeout(h),h=setTimeout(u,e)},t(e.delayError)):(clearTimeout(h),t=null,s?_(a.errors,r,s):Y(a.errors,r)),(s?!te(l,s):l)||!C(i)||o){const e={...i,...o&&g(n)?{isValid:n}:{},errors:a.errors,name:r};a={...a,...e},E.state.next(e)}})(o,S,d,L))}var v},se=(e,t)=>{if(b(a.errors,t)&&e.focus)return e.focus(),1},ie=async(e,t={})=>{let s,i;const l=T(e);if(r.resolver){const t=await(async e=>{const{errors:t}=await $(e);if(e)for(const r of e){const e=b(t,r);e?_(a.errors,r,e):Y(a.errors,r)}else a.errors=t;return t})(v(e)?e:l);s=C(t),i=e?!l.some((e=>b(t,e))):s}else e?(i=(await Promise.all(l.map((async e=>{const t=b(n,e);return await z(t&&t._f?{[e]:t}:t)})))).every(Boolean),(i||a.isValid)&&D()):i=s=await z(n);return E.state.next({...!O(e)||V.isValid&&s!==a.isValid?{}:{name:e},...r.resolver||!e?{isValid:s}:{},errors:a.errors}),t.shouldFocus&&!i&&N(n,se,e?l:p.mount),i},ye=e=>{const t={...d.mount?u:s};return v(e)?t:O(e)?b(t,e):e.map((e=>b(t,e)))},ve=(e,t)=>({invalid:!!b((t||a).errors,e),isDirty:!!b((t||a).dirtyFields,e),error:b((t||a).errors,e),isValidating:!!b(a.validatingFields,e),isTouched:!!b((t||a).touchedFields,e)}),be=(e,t,r)=>{const s=(b(n,e,{_f:{}})._f||{}).ref,i=b(a.errors,e)||{},{ref:l,message:o,type:u,...c}=i;_(a.errors,e,{...c,...t,ref:s}),E.state.next({name:e,errors:a.errors,isValid:!1}),r&&r.shouldFocus&&s&&s.focus&&s.focus()},ge=(e,t={})=>{for(const i of e?T(e):p.mount)p.mount.delete(i),p.array.delete(i),t.keepValue||(Y(n,i),Y(u,i)),!t.keepError&&Y(a.errors,i),!t.keepDirty&&Y(a.dirtyFields,i),!t.keepTouched&&Y(a.touchedFields,i),!t.keepIsValidating&&Y(a.validatingFields,i),!r.shouldUnregister&&!t.keepDefaultValue&&Y(s,i);E.values.next({values:{...u}}),E.state.next({...a,...t.keepDirty?{isDirty:H()}:{}}),!t.keepIsValid&&D()},pe=({disabled:e,name:t,field:r,fields:a,value:n})=>{if(g(e)&&d.mount||e){const s=e?void 0:v(n)?ue(r?r._f:b(a,t)._f):n;_(u,t,s),G(t,s,!1,!1,!0)}},he=(t,a={})=>{let l=b(n,t);const o=g(a.disabled)||g(e.disabled);return _(n,t,{...l||{},_f:{...l&&l._f?l._f:{ref:{name:t}},name:t,mount:!0,...a}}),p.mount.add(t),l?pe({field:l,disabled:g(a.disabled)?a.disabled:e.disabled,name:t,value:a.value}):U(t,!0,a.value),{...o?{disabled:a.disabled||e.disabled}:{},...r.progressive?{required:!!a.required,min:ce(a.min),max:ce(a.max),minLength:ce(a.minLength),maxLength:ce(a.maxLength),pattern:ce(a.pattern)}:{},name:t,onChange:ne,onBlur:ne,ref:e=>{if(e){he(t,a),l=b(n,t);const r=v(e.value)&&e.querySelectorAll&&e.querySelectorAll("input,select,textarea")[0]||e,o=(e=>I(e)||i(e))(r),u=l._f.refs||[];if(o?u.find((e=>e===r)):r===l._f.ref)return;_(n,t,{_f:{...l._f,...o?{refs:[...u.filter(ae),r,...Array.isArray(b(s,t))?[{}]:[]],ref:{type:r.type,name:t}}:{ref:r}}}),U(t,!1,void 0,r)}else l=b(n,t,{}),l._f&&(l._f.mount=!1),(r.shouldUnregister||a.shouldUnregister)&&(!((e,t)=>e.has((e=>e.substring(0,e.search(/\.\d+(\.|$)/))||e)(t)))(p.array,t)||!d.action)&&p.unMount.add(t)}}},_e=()=>r.shouldFocusError&&N(n,se,p.mount),xe=(e,t)=>async s=>{let i;s&&(s.preventDefault&&s.preventDefault(),s.persist&&s.persist());let l=m(u);if(E.state.next({isSubmitting:!0}),r.resolver){const{errors:e,values:t}=await $();a.errors=e,l=t}else await z(n);if(Y(a.errors,"root"),C(a.errors)){E.state.next({errors:{}});try{await e(l,s)}catch(e){i=e}}else t&&await t({...a.errors},s),_e(),setTimeout(_e);if(E.state.next({isSubmitted:!0,isSubmitting:!1,isSubmitSuccessful:C(a.errors)&&!i,submitCount:a.submitCount+1,errors:a.errors}),i)throw i},Ae=(t,r={})=>{const i=t?m(t):s,l=m(i),o=C(t),c=o?s:l;if(r.keepDefaultValues||(s=i),!r.keepValues){if(r.keepDirtyValues)for(const e of p.mount)b(a.dirtyFields,e)?_(c,e,b(u,e)):Q(e,b(c,e));else{if(f&&v(t))for(const e of p.mount){const t=b(n,e);if(t&&t._f){const e=Array.isArray(t._f.refs)?t._f.refs[0]:t._f.ref;if(B(e)){const t=e.closest("form");if(t){t.reset();break}}}}n={}}u=e.shouldUnregister?r.keepDefaultValues?m(s):{}:m(c),E.array.next({values:{...c}}),E.values.next({values:{...c}})}p={mount:r.keepDirtyValues?p.mount:new Set,unMount:new Set,array:new Set,watch:new Set,watchAll:!1,focus:""},d.mount=!V.isValid||!!r.keepIsValid||!!r.keepDirtyValues,d.watch=!!e.shouldUnregister,E.state.next({submitCount:r.keepSubmitCount?a.submitCount:0,isDirty:!o&&(r.keepDirty?a.isDirty:!(!r.keepDefaultValues||te(t,s))),isSubmitted:!!r.keepIsSubmitted&&a.isSubmitted,dirtyFields:o?{}:r.keepDirtyValues?r.keepDefaultValues&&u?le(s,u):a.dirtyFields:r.keepDefaultValues&&t?le(s,t):r.keepDirty?a.dirtyFields:{},touchedFields:r.keepTouched?a.touchedFields:{},errors:r.keepErrors?a.errors:{},isSubmitSuccessful:!!r.keepIsSubmitSuccessful&&a.isSubmitSuccessful,isSubmitting:!1})},Ve=(e,t)=>Ae(M(e)?e(u):e,t);return{control:{register:he,unregister:ge,getFieldState:ve,handleSubmit:xe,setError:be,_executeSchema:$,_getWatch:W,_getDirty:H,_updateValid:D,_removeUnmounted:()=>{for(const e of p.unMount){const t=b(n,e);t&&(t._f.refs?t._f.refs.every((e=>!ae(e))):!ae(t._f.ref))&&ge(e)}p.unMount=new Set},_updateFieldArray:(e,t=[],r,i,l=!0,o=!0)=>{if(i&&r){if(d.action=!0,o&&Array.isArray(b(n,e))){const t=r(b(n,e),i.argA,i.argB);l&&_(n,e,t)}if(o&&Array.isArray(b(a.errors,e))){const t=r(b(a.errors,e),i.argA,i.argB);l&&_(a.errors,e,t),((e,t)=>{!y(b(e,t)).length&&Y(e,t)})(a.errors,e)}if(V.touchedFields&&o&&Array.isArray(b(a.touchedFields,e))){const t=r(b(a.touchedFields,e),i.argA,i.argB);l&&_(a.touchedFields,e,t)}V.dirtyFields&&(a.dirtyFields=le(s,u)),E.state.next({name:e,isDirty:H(e,t),dirtyFields:a.dirtyFields,errors:a.errors,isValid:a.isValid})}else _(u,e,t)},_updateDisabledField:pe,_getFieldArray:t=>y(b(d.mount?u:s,t,e.shouldUnregister?b(s,t,[]):[])),_reset:Ae,_resetDefaultValues:()=>M(r.defaultValues)&&r.defaultValues().then((e=>{Ve(e,r.resetOptions),E.state.next({isLoading:!1})})),_updateFormState:e=>{a={...a,...e}},_disableForm:e=>{g(e)&&(E.state.next({disabled:e}),N(n,((t,r)=>{const a=b(n,r);a&&(t.disabled=a._f.disabled||e,Array.isArray(a._f.refs)&&a._f.refs.forEach((t=>{t.disabled=a._f.disabled||e})))}),0,!1))},_subjects:E,_proxyFormState:V,_setErrors:e=>{a.errors=e,E.state.next({errors:a.errors,isValid:!1})},get _fields(){return n},get _formValues(){return u},get _state(){return d},set _state(e){d=e},get _defaultValues(){return s},get _names(){return p},set _names(e){p=e},get _formState(){return a},set _formState(e){a=e},get _options(){return r},set _options(e){r={...r,...e}}},trigger:ie,register:he,handleSubmit:xe,watch:(e,t)=>M(e)?E.values.subscribe({next:r=>e(W(void 0,t),r)}):W(e,t,!0),setValue:Q,getValues:ye,reset:Ve,resetField:(e,t={})=>{b(n,e)&&(v(t.defaultValue)?Q(e,m(b(s,e))):(Q(e,t.defaultValue),_(s,e,m(t.defaultValue))),t.keepTouched||Y(a.touchedFields,e),t.keepDirty||(Y(a.dirtyFields,e),a.isDirty=t.defaultValue?H(e,m(b(s,e))):H()),t.keepError||(Y(a.errors,e),V.isValid&&D()),E.state.next({...a}))},clearErrors:e=>{e&&T(e).forEach((e=>Y(a.errors,e))),E.state.next({errors:e?a.errors:{}})},unregister:ge,setError:be,setFocus:(e,t={})=>{const r=b(n,e),a=r&&r._f;if(a){const e=a.refs?a.refs[0]:a.ref;e.focus&&(e.focus(),t.shouldSelect&&e.select())}},getFieldState:ve}}function ve(){return ve=Object.assign?Object.assign.bind():function(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var a in r)({}).hasOwnProperty.call(r,a)&&(e[a]=r[a])}return e},ve.apply(null,arguments)}var be=function(t){var r=t.register;return React.createElement(e.__experimentalGrid,{gap:2,style:{marginTop:"15px"}},React.createElement(e.TextControl,ve({label:"Nombre"},r("first_name",{required:!0}))),React.createElement(e.TextControl,ve({label:"Nombre"},r("last_name",{required:!0}))),React.createElement(e.TextControl,ve({label:"Email"},r("email",{required:!0}))),React.createElement(e.TextControl,ve({label:"Teléfono"},r("phone_number",{required:!0}))),React.createElement(e.TextControl,ve({label:"Nombre de la EPS"},r("eps",{required:!0}))),React.createElement(e.TextControl,ve({label:"Talla de camiseta"},r("shirt_size",{required:!0}))),React.createElement(e.TextControl,ve({label:"Estado civil"},r("marital_status",{required:!0}))),React.createElement(e.TextControl,ve({label:"Fecha de nacimiento"},r("birthdate",{required:!0}))))};function ge(){return ge=Object.assign?Object.assign.bind():function(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var a in r)({}).hasOwnProperty.call(r,a)&&(e[a]=r[a])}return e},ge.apply(null,arguments)}var pe=function(t){var r=t.register;return React.createElement(e.__experimentalGrid,{gap:2,style:{marginTop:"15px"}},React.createElement(e.TextControl,ge({label:"Nombre de contacto de emergencia 1"},r("emergency_contact_name_1",{required:!0}))),React.createElement(e.TextControl,ge({label:"Teléfono de contacto de emergencia 1"},r("emergency_contact_phone_1",{required:!0}))),React.createElement(e.TextControl,ge({label:"Parentesco de contacto de emergencia 1"},r("emergency_contact_relationship_1",{required:!0}))),React.createElement(e.TextControl,ge({label:"Nombre de contacto de emergencia 2"},r("emergency_contact_name_2",{required:!0}))),React.createElement(e.TextControl,ge({label:"Teléfono de contacto de emergencia 2"},r("emergency_contact_phone_2",{required:!0}))),React.createElement(e.TextControl,ge({label:"Parentesco de contacto de emergencia 2"},r("emergency_contact_relationship_2",{required:!0}))),React.createElement(e.TextControl,ge({label:"Nombre de la persona que paga"},r("payment_by_name",{required:!0}))),React.createElement(e.TextControl,ge({label:"Teléfono de la persona que paga"},r("payment_by_phone",{required:!0}))),React.createElement(e.TextControl,ge({label:"Nombre de la persona que invita"},r("invited_by_name",{required:!0}))),React.createElement(e.TextControl,ge({label:"Teléfono de la persona que invita"},r("invited_by_phone",{required:!0}))),React.createElement(e.TextControl,ge({label:"Parentesco de la persona que invita"},r("invited_by_relationship",{required:!0}))),React.createElement(e.TextControl,ge({label:"¿La persona que invita es servidor?"},r("invited_contact_is_servant",{required:!0}))))};function he(){return he=Object.assign?Object.assign.bind():function(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var a in r)({}).hasOwnProperty.call(r,a)&&(e[a]=r[a])}return e},he.apply(null,arguments)}var _e=function(t){var r=t.register;return React.createElement(e.__experimentalGrid,{gap:2,style:{marginTop:"15px"}},React.createElement(e.TextareaControl,he({label:"¿Tiene alguna condición médica?"},r("medical_condition",{required:!0}))),React.createElement(e.TextareaControl,he({label:"¿Tiene alguna dieta especial?"},r("special_diet",{required:!0}))),React.createElement(e.TextareaControl,he({label:"Notas adicionales"},r("additional_notes",{required:!0}))))},xe=function(t){var r=t.setModalOpen,a=function(e={}){const t=s.useRef(),r=s.useRef(),[a,n]=s.useState({isDirty:!1,isValidating:!1,isLoading:M(e.defaultValues),isSubmitted:!1,isSubmitting:!1,isSubmitSuccessful:!1,isValid:!1,submitCount:0,dirtyFields:{},touchedFields:{},validatingFields:{},errors:e.errors||{},disabled:e.disabled||!1,defaultValues:M(e.defaultValues)?void 0:e.defaultValues});t.current||(t.current={...ye(e),formState:a});const i=t.current.control;return i._options=e,function(e){const t=s.useRef(e);t.current=e,s.useEffect((()=>{const r=!e.disabled&&t.current.subject&&t.current.subject.subscribe({next:t.current.next});return()=>{r&&r.unsubscribe()}}),[e.disabled])}({subject:i._subjects.state,next:e=>{((e,t,r,a)=>{r(e);const{name:n,...s}=e;return C(s)||Object.keys(s).length>=Object.keys(t).length||Object.keys(s).find((e=>t[e]===(!a||S)))})(e,i._proxyFormState,i._updateFormState,!0)&&n({...i._formState})}}),s.useEffect((()=>i._disableForm(e.disabled)),[i,e.disabled]),s.useEffect((()=>{if(i._proxyFormState.isDirty){const e=i._getDirty();e!==a.isDirty&&i._subjects.state.next({isDirty:e})}}),[i,a.isDirty]),s.useEffect((()=>{e.values&&!te(e.values,r.current)?(i._reset(e.values,i._options.resetOptions),r.current=e.values,n((e=>({...e})))):i._resetDefaultValues()}),[e.values,i]),s.useEffect((()=>{e.errors&&i._setErrors(e.errors)}),[e.errors,i]),s.useEffect((()=>{i._state.mount||(i._updateValid(),i._state.mount=!0),i._state.watch&&(i._state.watch=!1,i._subjects.state.next({...i._formState})),i._removeUnmounted()})),s.useEffect((()=>{e.shouldUnregister&&i._subjects.values.next({values:i._getWatch()})}),[e.shouldUnregister,i]),t.current.formState=((e,t,r,a=!0)=>{const n={defaultValues:t._defaultValues};for(const s in e)Object.defineProperty(n,s,{get:()=>{const n=s;return t._proxyFormState[n]!==S&&(t._proxyFormState[n]=!a||S),r&&(r[n]=!0),e[n]}});return n})(a,i),t.current}({defaultValues:t.data}),n=a.register,i=a.handleSubmit;return a.watch,a.formState.errors,React.createElement(e.Modal,{title:"Editar Información del Usuario",onRequestClose:function(){return r(!1)},size:"large"},React.createElement("form",{onSubmit:i((function(){console.log("Saving user data..."),r(!1)}))},React.createElement(e.TabPanel,{tabs:[{name:"tab1",title:"Información Personal",content:React.createElement(be,{register:n})},{name:"tab2",title:"Información de Contacto",content:React.createElement(pe,{register:n})},{name:"tab3",title:"Información Adicional",content:React.createElement(_e,{register:n})}]},(function(e){return React.createElement("div",{className:e.className},e.content)})),React.createElement(e.Button,{type:"submit",variant:"secondary"},"Guardar")))};function Ae(e,t){(null==t||t>e.length)&&(t=e.length);for(var r=0,a=Array(t);r<t;r++)a[r]=e[r];return a}var Ve=function(e){var t,r,s=e.data,i=(t=(0,n.useState)(!1),r=2,function(e){if(Array.isArray(e))return e}(t)||function(e,t){var r=null==e?null:"undefined"!=typeof Symbol&&e[Symbol.iterator]||e["@@iterator"];if(null!=r){var a,n,s,i,l=[],o=!0,u=!1;try{if(s=(r=r.call(e)).next,0===t){if(Object(r)!==r)return;o=!1}else for(;!(o=(a=s.call(r)).done)&&(l.push(a.value),l.length!==t);o=!0);}catch(e){u=!0,n=e}finally{try{if(!o&&null!=r.return&&(i=r.return(),Object(i)!==i))return}finally{if(u)throw n}}return l}}(t,r)||function(e,t){if(e){if("string"==typeof e)return Ae(e,t);var r={}.toString.call(e).slice(8,-1);return"Object"===r&&e.constructor&&(r=e.constructor.name),"Map"===r||"Set"===r?Array.from(e):"Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r)?Ae(e,t):void 0}}(t,r)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()),l=i[0],o=i[1];return React.createElement(React.Fragment,null,React.createElement(a,{data:s,onEditClick:o}),l&&React.createElement(xe,{data:s,setModalOpen:o}))};document.addEventListener("DOMContentLoaded",(function(){document.querySelectorAll(".user-table-row").forEach((function(e){var t=JSON.parse(e.getAttribute("data-walker")),r=e.querySelector(".user-action-container");wp.element.render(React.createElement(Ve,{data:t}),r)}))}))})();