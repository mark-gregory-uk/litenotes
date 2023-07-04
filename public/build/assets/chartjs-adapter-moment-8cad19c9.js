import{h as r}from"./moment-fbc5633a.js";import{a as o}from"./chart.js-63200d26.js";/*!
  * chartjs-adapter-moment v1.0.1
  * https://www.chartjs.org
  * (c) 2022 chartjs-adapter-moment Contributors
  * Released under the MIT license
  */const a={datetime:"MMM D, YYYY, h:mm:ss a",millisecond:"h:mm:ss.SSS a",second:"h:mm:ss a",minute:"h:mm a",hour:"hA",day:"MMM D",week:"ll",month:"MMM YYYY",quarter:"[Q]Q - YYYY",year:"YYYY"};o._date.override(typeof r=="function"?{_id:"moment",formats:function(){return a},parse:function(t,n){return typeof t=="string"&&typeof n=="string"?t=r(t,n):t instanceof r||(t=r(t)),t.isValid()?t.valueOf():null},format:function(t,n){return r(t).format(n)},add:function(t,n,f){return r(t).add(n,f).valueOf()},diff:function(t,n,f){return r(t).diff(r(n),f)},startOf:function(t,n,f){return t=r(t),n==="isoWeek"?(f=Math.trunc(Math.min(Math.max(0,f),6)),t.isoWeekday(f).startOf("day").valueOf()):t.startOf(n).valueOf()},endOf:function(t,n){return r(t).endOf(n).valueOf()}}:{});
