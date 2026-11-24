import { useEffect, useState } from 'react';

/**
 * Today's joke from GiggleTime.
 * Usage: <JokeOfTheDay lang="es" />
 */
export default function JokeOfTheDay({ lang = 'en' }) {
  const [data, setData] = useState(null);
  const [revealed, setRevealed] = useState(false);

  useEffect(() => {
    let cancelled = false;
    setRevealed(false);
    fetch(`https://www.giggletime.app/embed/today?lang=${encodeURIComponent(lang)}`)
      .then((response) => response.json())
      .then((json) => { if (!cancelled) setData(json); })
      .catch(() => { if (!cancelled) setData(null); });
    return () => { cancelled = true; };
  }, [lang]);

  if (!data || !data.joke) return null;
  const { labels, joke } = data;
  const twoPart = joke.setup && joke.punchline;

  return (
    <div className="joke-of-the-day" dir={joke.rtl ? 'rtl' : 'ltr'}>
      <strong>{labels.title}</strong>
      <p>{twoPart ? joke.setup : joke.text}</p>
      {twoPart && (revealed
        ? <p>{joke.punchline}</p>
        : <button type="button" onClick={() => setRevealed(true)}>{labels.reveal}</button>)}
      <p>
        <small>Joke of the day by <a href={joke.url}>GiggleTime</a></small>
      </p>
    </div>
  );
}
